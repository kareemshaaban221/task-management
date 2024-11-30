<?php

/**
 * This file contains the TaskStatusEnum class used within the application.
 *
 * The TaskStatusEnum class represents a PHP enum that provides utility methods for
 * working with task statuses, allowing for easier and more readable access to task
 * status names, values, and cases. It includes methods for retrieving an array of task
 * status names and values, as well as searching for a specific task status case by name
 * or value. Additionally, the class implements a magic method to facilitate static
 * method calls to task status cases, throwing an exception if the requested case does
 * not exist.
 *
 * @category Enums
 * @package  App\Enums
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Enums;

use App\Traits\Enum;

/**
 * TaskStatusEnum
 *
 * @method static string OPEN()
 * @method static string PENDING()
 * @method static string IN_PROGRESS()
 * @method static string COMPLETED()
 * @method static string CANCELLED()
 */
enum TaskStatusEnum: string
{
    use Enum;

    case OPEN = 'open';
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case OVER_DUE = 'over_due';
    case CANCELLED = 'cancelled';

}
