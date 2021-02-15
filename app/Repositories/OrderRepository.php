<?php

namespace App\Repositories;


use Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Contracts\OrderContract;
use App\Models\Commission;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderContract
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function storeAppOrderDetails($params){

        $se_commissions = Commission::where('status', 1)->first();



        $collection = collect($params)->except('_token');

        $status                 = 'pending';
        $user_id                = auth()->user()->id;
        $order_number           = 'ORD-'.strtoupper(uniqid());
        $ps_commission          = config('settings.personal_shopper_tier_1');
        $agent_commission       = config('settings.personal_shopper_tier_2');
        $ps_agent_commission    = config('settings.personal_shopper_tier_3');
        $se_commission          = $se_commissions->id;
        // $grand_total    =  100;
        // $item_count     =  100;
        // $sub_total      =  100;
        // $tax            =  100;

        $merge = $collection
        ->merge(
            compact(
                'status',
                'user_id',
                'order_number',
                'ps_commission',
                'agent_commission',
                'ps_agent_commission',
                'se_commission',
                )
            );

        $order = new Order($merge->all());

        $order->save();

        if ($order) {

            $items = json_decode($params['products'],true);

            foreach ($items as $item) {

                //collect all inserted record IDs
                $price = 0;

                if($item['sale_price'] > 0){
                    $price = $item['sale_price'];
                }else{
                    $price = $item['price'];

                }

                $product = Product::find($item['id']);
                $product->decrement('quantity', $item['amount']);

                $item_id_array[$item['id']] = ['price' => $price, 'quantity' => $item['amount']];

            }



            //Insert into order_products table
            $order->products()->sync($item_id_array);//dont delete old entries = false



        }

        return $order;

    }

    public function updateAppOrderDetails($params){


        $order = $this->findOrderById($params['id']);

        $collection = collect($params)->except('_token');

        $payment_method = $params['payment'];

        $merge = $collection->merge(compact('payment_method'));

        $order->update($merge->all());

        return $order;


    }

    public function storeOrderDetails($params)
    {
        $order = Order::create([
            'order_number'      =>  'ORD-'.strtoupper(uniqid()),
            'user_id'           => auth()->user()->id,
            'status'            =>  'pending',
            'grand_total'       =>  Cart::getSubTotal(),
            'item_count'        =>  Cart::getTotalQuantity(),
            'payment_status'    =>  0,
            'payment_method'    =>  null,
            'first_name'        =>  $params['first_name'],
            'last_name'         =>  $params['last_name'],
            'address'           =>  $params['address'],
            'city'              =>  $params['city'],
            'country'           =>  $params['country'],
            'post_code'         =>  $params['post_code'],
            'phone_number'      =>  $params['phone_number'],
            'notes'             =>  $params['notes']
        ]);

        if ($order) {

            $items = Cart::getContent();

            foreach ($items as $item)
            {
                // A better way will be to bring the product id with the cart items
                // you can explore the package documentation to send product id with the cart
                $product = Product::where('name', $item->name)->first();

                $orderItem = new OrderItem([
                    'product_id'    =>  $product->id,
                    'quantity'      =>  $item->quantity,
                    'price'         =>  $item->getPriceSum()
                ]);

                $order->items()->save($orderItem);
            }
        }

        return $order;
    }

    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function findOrderByNumber($orderNumber)
    {
        return Order::where('order_number', $orderNumber)->first();
    }

    public function findOrderById($id)
    {
        return Order::where('id', $id)->first();
    }
}
