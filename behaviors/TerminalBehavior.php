<?php
/**
 * @file    TerminalBehavior.php
 * @date    26/8/2015
 * @time    3:07 AM
 * @author  Henry <alvin_vna@yahoo.com>
 * @copyright Copyright (c) 2015 Perpustakaan Nasional Republik Indonesia
 * @license
 */

namespace andydodot\dodotgii\behaviors;


use yii\behaviors\AttributeBehavior;
use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * TerminalBehavior automatically fills the specified attributes with the current IP.
 *
 * To use TerminalBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use andydodot\dodotgii\behaviors\TerminalBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         TerminalBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, TerminalBehavior will fill the `created_terminal` and `updated_terminal` attributes with the current IP
 * when the associated AR object is being inserted; it will fill the `updated_terminal` attribute
 * with the timestamp when the AR object is being updated. The timestamp value is obtained by `time()`.
 *
 * If your attribute names are different or you want to use a different way of calculating the timestamp,
 * you may configure the [[createdTerminalAttribute]], [[updatedTerminalAttribute]] and [[value]] properties like the following:
 *
 * ```php
 * 
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => TerminalBehavior::className(),
 *             'createdTerminalAttribute' => 'CreateTerminal',
 *             'updatedTerminalAttribute' => 'UpdateTerminal',
 *             'value' => \Yii::$app->request->userIP,
 *         ],
 *     ];
 * }
 * ```
 *
 * In case you use an [[Expression]] object as in the example above, the attribute will not hold the timestamp value, but
 * the Expression object itself after the record has been saved. If you need the value from DB afterwards you should call
 * the [[\yii\db\ActiveRecord::refresh()|refresh()]] method of the record.
 *
 * TimestampBehavior also provides a method named [[touch()]] that allows you to assign the current
 * timestamp to the specified attribute(s) and save them to the database. For example,
 *
 * ```php
 * $model->touch('creation_time');
 * ```
 *
 * @author Henry <alvin_vna@yahoo.com>
 * @since 1.0
 */
class TerminalBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive timestamp value
     * Set this property to false if you do not want to record the creation time.
     */
    public $createdTerminalAttribute = 'created_terminal';
    /**
     * @var string the attribute that will receive timestamp value.
     * Set this property to false if you do not want to record the update time.
     */
    public $updatedTerminalAttribute = 'updated_terminal';
    /**
     * @var callable|Expression The expression that will be used for generating the timestamp.
     * This can be either an anonymous function that returns the timestamp value,
     * or an [[Expression]] object representing a DB expression (e.g. `new Expression('NOW()')`).
     * If not set, it will use the value of `time()` to set the attributes.
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdTerminalAttribute, $this->updatedTerminalAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedTerminalAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value !== null) {
            return $this->value;
        } else {
            return call_user_func($this->value, $event);
        }

       /* if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : time();
        }*/
    }

    /**
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     * @throws InvalidCallException if owner is a new record (since version 2.0.6).
     */
    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}