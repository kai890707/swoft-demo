<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Controller;

use App\Model\Data\GoodsData;
use Swoft;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Throwable;
use function bean;
use function context;
use Swoft\Co;
/**
 * Class CreateOrder
 * @Controller()
 */
class CreateOrder
{
    /**
     * @RequestMapping("createOrder")
     * @throws Throwable
     */
    public function index(): Response
    {
        // Co::create(function () {
        return context()->getResponse()->withContent('你好');
        // });

        // return Co::multi($requests);
    }
}
