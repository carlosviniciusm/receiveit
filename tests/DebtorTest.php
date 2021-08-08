<?php

use framework\exceptions\InvalidAttributeException;
use PHPUnit\Framework\TestCase;
use src\dao\DebtorDAO;
use src\model\debtor\Debtor;

/**
 * Class DebtorTest
 */
class DebtorTest extends TestCase
{
    /**
     * Test save fake debtor
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveGeneral()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm321@gmail.com',
            'cpfcnpj' => '01234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Deputado Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste',
            'neighborhood' => 'Bairro Teste',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $oDebtor = Debtor::createFromRequest($aDados);
        $oDebtor->save();

        $oDebtorDAO = new DebtorDAO();
        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');
        $this->assertTrue(!is_null($oDebtor->getId()));
    }

    /**
     * Test save same CPF/CNPJ
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveSameCpf()
    {
        $aDados = [
            'name' => 'Carlos Teste',
            'email' => 'cvmm121@gmail.com',
            'cpfcnpj' => '01234567890',
            'birthdate' => '15/01/1996',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $oDebtor = Debtor::createFromRequest($aDados);
        $this->expectException(PDOException::class);
        $oDebtor->save();
        $oDebtorDAO = new DebtorDAO();
        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');
        $this->assertTrue(!is_null($oDebtor->getId()));
    }

    /**
     * Test delete fake debtor
     */
    public function testDebtorDelete()
    {
        $oDebtorDAO = new DebtorDAO();
        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');

        $this->assertTrue(!is_null($oDebtor->getId()));

        $oDebtor->delete();

        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');
        $this->assertFalse(!is_null($oDebtor->getId()));
    }
}