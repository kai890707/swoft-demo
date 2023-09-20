<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Controller\V2;

use App\Model\Data\GoodsData;
use Swoft;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Response;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use App\Anser\Orchestrators\V2\CreateOrderOrchestrator;
use function context;
use Swoft\Log\Helper\Log;

/**
 * Class CreateOrder
 * @Controller()
 */
class CreateOrder
{
    /**
     * @RequestMapping("createOrder")
     *
     * @return Response
     */
    public function createOrder(Request $request): Response
    {
        $data = json_decode($request->raw());
        $memberKey = $data->memberKey;
        $products = $data->products;

        $createOrder = new CreateOrderOrchestrator();

		$data = $createOrder->build($products, $memberKey);
	    $result = $data ?? ["order_key" => $createOrder->orderKey];
	    Log::info(json_encode($result));

        return context()->getResponse()->withContentType(ContentType::HTML)->withContent(json_encode($result));
    }

}
