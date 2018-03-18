<?php
namespace Eu\Righettod\Pocargon2;

require_once('password_util.php');
use Eu\Righettod\Pocargon2\PasswordUtil as PUtil;
use PHPUnit\Framework\TestCase;

/**
* Test suites for the class "PasswordUtil".
*/
class PasswordUtilTest extends TestCase
{
    /**
    * Test to validate that the computation of a password's hash is functional:
    * - Hash is generated and is valid
    */
    public function testHashCorrectComputation()
    {
        $p = new PUtil();
        $password = "testHashCorrectComputation";
        $hash = $p->hash($password);
        $this->assertNotEmpty($hash, "Hash must not be empty");
        $hash_infos = password_get_info($hash);
        $this->assertEquals("argon2i", $hash_infos["algoName"], "Hash algorithm must be Argon2i");
        $this->assertEquals(3, count($hash_infos), "Hash first set of information must have 3 parts");
        $this->assertEquals(3, count($hash_infos["options"]), "Hash last set of information must have 3 parts");
    }


    /**
     * Test to validate that the verification of a password's hash is functional when password match is expected:
     * - Hash is verified and return true
     */
    public function testHashCorrectVerificationCaseOk()
    {
        $p = new PUtil();
        $password = "testHashCorrectVerificationCaseOk";
        $hash = $p->hash($password);
        $isValid = password_verify($password, $hash);
        $this->assertTrue($isValid, "Hash must match passed password");
    }

    /**
    * Test to validate that the verification of a password's hash is functional when password match is not expected:
    * - Hash is verified and return false
     */
    public function testHashCorrectVerificationCaseKo()
    {
        $p = new PUtil();
        $password = "testHashCorrectVerificationCaseKo";
        $hash = $p->hash($password);
        $isValid = password_verify("testBadPassword", $hash);
        $this->assertFalse($isValid, "Hash must not match passed password");
    }

    /**
      * Test that the computation time of a hash take at least 2 seconds
      */
    public function testComputationDelay()
    {
        $p = new PUtil();
        $password = "testComputationDelay";
        $start = microtime(true);
        $hash = $p->hash($password);
        $timeElapsedInSeconds = microtime(true) - $start;
        $failMsg = "Duration must be >= to 2 seconds and the current result is " . $timeElapsedInSeconds . " seconds";
        $this->assertTrue($timeElapsedInSeconds >= 2, $failMsg);
    }

    /**
    * Test that the password function can handle very big string
    */
    public function testVeryBigPassword(){
      $p = new PUtil();
      $password = str_repeat("X", 10000000);
      $start = microtime(true);
      $hash = $p->hash($password);
      $timeElapsedInSeconds = microtime(true) - $start;
      $isValid = password_verify($password, $hash);
      $this->assertTrue($isValid, "Hash must match passed password");
      $failMsg = "Duration must be >= to 2 seconds and the current result is " . $timeElapsedInSeconds . " seconds";
      $this->assertTrue($timeElapsedInSeconds >= 2, $failMsg);
    }
}
