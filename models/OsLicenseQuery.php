<?php

namespace marqu3s\itam\models;

use \yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[OsLicense]].
 *
 * @see OsLicence
 */
class OsLicenseQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OsLicense[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OsLicense|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
