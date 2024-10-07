<?php

namespace App\Livewire;

use Livewire\Component;
use ZxcvbnPhp\Zxcvbn;

class PasswordChecker extends Component
{
    public string $password = '';
    public int $strengthScore = 1;
    public array $strengthLevels = [
        1 => 'weak',
        2 => 'fair',
        3 => 'good',
        4 => 'strong',
    ];
    public function updatedPassword($value)
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    public function render()
    {
        return view('livewire.password-checker');
    }
}