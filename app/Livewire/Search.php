<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Client;
use App\Models\Seller;
use App\Models\User;
use Livewire\Component;

#[AllowDynamicProperties] class Search extends Component
{
    public $search = '';
    public $results = [];

    public function render()
    {
        if (strlen($this->search) >= 1) {
            $users = User::where('name', 'like', '%' . $this->search . '%')
                ->Orwhere('email', 'like', '%' . $this->search . '%')
                ->limit(5)
                ->get()
                ->map(function ($user) {
                    return [
                        'model' => $user,
                        'type' => 'user',
                        'name' => $user->name,
                        'email' => $user->email,
                    ];
                });
            $sellers = Seller::where('restaurant_name', 'like', '%' . $this->search . '%')
                ->Orwhere('email', 'like', '%' . $this->search . '%')
                ->limit(5)
                ->get()
                ->map(function ($seller) {
                    return [
                        'model' => $seller,
                        'type' => 'seller',
                        'name' => $seller->restaurant_name,
                        'email' => $seller->email,
                    ];
                });
            $clients = Client::where('name', 'like', '%' . $this->search . '%')
                ->Orwhere('email', 'like', '%' . $this->search . '%')
                ->limit(5)
                ->get()
                ->map(function ($client) {
                    return [
                        'model' => $client,
                        'type' => 'client',
                        'name' => $client->name,
                        'email' => $client->email,
                    ];
                });
            $this->results = array_merge($users->toArray(), $sellers->toArray(), $clients->toArray());
        } else {
            $this->results = [];
        }
        return view('livewire.search', ['users' => $this->results]);
    }

}
