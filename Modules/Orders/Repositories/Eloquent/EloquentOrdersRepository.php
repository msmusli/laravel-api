<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Orders\Repositories\Eloquent;

use App\Repositories\Criteria\ByCustomerOrProvider;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Select;
use App\Repositories\Criteria\WhereIn;
use App\Repositories\Criteria\WithTrashed;
use App\Repositories\RepositoryAbstract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Orders\Entities\Order;
use Modules\Orders\Repositories\Contracts\OrdersRepository;

/**
 * Class EloquentOrdersRepository.
 */
class EloquentOrdersRepository extends RepositoryAbstract implements OrdersRepository
{
    public function model()
    {
        return Order::class;
    }

    public function getOrders (array $transactions = []): Collection
    {
        return $this->withCriteria([
            new WithTrashed(),
            new Select('id', 'name', 'price', 'quantity', 'user_id', 'transaction_id', 'event_id', 'created_at'),
            new OrderBy('orders.id', 'desc'),
            new WhereIn('orders.transaction_id', $transactions),
            new EagerLoad(['user' => function ($query) {
                $query->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile');
            }, 'transaction' => function ($query) {
                $query->select('transactions.id', 'transactions.gateway');
            }, 'event' => function ($query) {
                $query->select('events.id', 'events.title');
            }])
        ])->all();
    }
}
