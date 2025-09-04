<?php

namespace Tests\Browser;

use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_admin_can_login()
    {
        $this->browse(function (Browser $browser) {
            $randomName = Str::random(8);
            $randomEmail = 'jean' . Str::random(5) . '@example.com';

            $browser->visit('/login')
                ->waitFor('input[name=email]')
                ->type('email', 'admin@edocshool.local')
                ->type('password', 'passworda')
                ->screenshot('login')
                ->press('button[type=submit]')
                ->assertPathIs('/admin/dashboard')

                // Formulaire d’ajout d’un enseignant
                ->visit('/admin/teachers/create')
                ->type('first_name', $randomName)
                ->type('last_name', 'Dupont')
                ->type('email', $randomEmail)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->check('school_class_ids[]', 1)
                ->check('school_class_ids[]', 2)
                ->screenshot('before_submit')

                // Clique sur "Enregistrer"
                ->press('Enregistrer')
                ->pause(2000)

                // Aller à la dernière page de la liste des enseignants
                ->visit('/admin/teachers?page=11')
                ->screenshot('final_check');

            // Tu peux aussi faire un test d'erreurs si besoin ici
        });
    }
}
