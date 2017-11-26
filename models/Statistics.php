<?php

namespace app\models;

/**
 * This is the model class for table "statistics".
 *
 * @property integer $id
 * @property integer $news_id
 * @property string $hash_code
 * @property integer $count_clicks
 * @property integer $client_ip
 * @property string $country_code
 * @property string $date
 *
 * @property News $news
 */
class Statistics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'hash_code', 'client_ip'], 'required'],
            [['news_id', 'hash_code', 'count_clicks'], 'integer'],
            [['date'], 'safe'],
            [['country_code'], 'string', 'max' => 2],
            [['hash_code'], 'string', 'max' => 32],
            [['client_ip'], 'string', 'max' => 20],
            [['client_ip'], 'match',
                'pattern' => '/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/'
            ],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(),
                'targetAttribute' => ['news_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'news_id'      => 'News ID',
            'hash_code'    => 'Hash code',
            'count_clicks' => 'Count clicks',
            'client_ip'    => 'IP',
            'country_code' => 'Country Code',
            'date'         => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    public function addClick() {
        $country_code = trim(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $this->client_ip));
        if (!$country_code) {
            return null;
        }

        $country_code = json_decode($country_code);
        if (!is_object($country_code)) {
            return null;
        }

        $existObject = self::findOne([
            'news_id'   => $this->news_id,
            'client_ip' => $this->client_ip,
            'hash_code' => $this->hash_code
        ]);

        if ($existObject) {
            $existObject->count_clicks += 1;
            $existObject->date = date('y-m-d H:i:s',time());
            $existObject->save(false);
        } else {
            $this->count_clicks = 1;
            $this->country_code = $country_code->geoplugin_countryCode;
            $this->save(false);
        }
    }
}
