<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase {
	
	use DatabaseTransactions;

	public function testLogin() {
		$this
			->visit('/auth/login')
			->type('admin@admin.hu', 'email')
			->type('123456', 'password')
			->press('Bejelentkezés')
			->seePageIs('/home');
	}
	
	public function testRegister() {
		$this
			->visit('/auth/register')
			->type('sally', 'name')
			->type('sally@example.com', 'email')
			->type('123456', 'password')
			->type('123456', 'password_confirmation')
			->press('Regisztráció')
			->seeInDatabase('users', ['email' => 'sally@example.com'])
			->seePageIs('/home');
		
		$this
			->visit('/auth/logout')
			->seePageIs('/');
		
		$this
			->visit('/auth/login')
			->type('asd@admin.hu', 'email')
			->type('654321', 'password')
			->press('Bejelentkezés')
			->see('A megadott adatokkal megegyező felhasználó nem található az adatbázisunkban.')
			->seePageIs('/auth/login');
		
		$this
			->visit('/auth/register')
			->type('sally', 'name')
			->type('sally@example.com', 'email')
			->type('123', 'password')
			->type('456', 'password_confirmation')
			->press('Regisztráció')
			->see('A(z) E-mail már foglalt.')
			->see('A(z) Jelszó nem egyezik a megerősítéssel.')
			->see('A(z) Jelszó hossza nem lehet kevesebb, mint 6 karakter.')
			->seePageIs('/auth/register');
	}

}
