<?php

/**
 * Precedential Model
 *
 * @package     Spiffy
 * @subpackage  Model
 * @category    Precedential
 * @author      Trioangle Product Team
 * @version     1.8
 * @link        http://trioangle.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Precedential extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'precedentials';

    public $timestamps = false;

    
}
