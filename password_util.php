<?php

namespace Eu\Righettod\Pocargon2;

/**
 * This class provided utility methods to create and verify a hash of a password.
 *
 * This implementation can be used to create a company internal shared php utility library that abstract application to know algorithm used and how to use it.
 *
 * As hash will be used for password type of information then the variant named "Argon2i" of Argon2 will be used.
 *
 * The hash creation method return a hash with all information in order to allow the application that need to verify the hash to be in a full stateless mode.
 */
class PasswordUtil
{
  /**
     * Compute a hash of a password.
     *
     * @param string $password Password to hash.
     * @return string The hash in format "$argon2i$v=19$m=1024,t=2,p=2$amRwcjA5ZUlUZDdDNEJHRg$B6K1JOhuh2IyEsDrGFZHrmD+118gtj1tKt1V1n2ftus"
     */
    public static function hash($password)
    {
        //Create options
        $options = self::loadParameters();
        //Compute the hash and return it
        return password_hash($password, PASSWORD_ARGON2I, $options);
    }


    /**
        * Verifies a password against a hash
        * Password provided is wiped at the end of this method
        *
        * @param string $password Password to which hash must be verified against.
        * @param string $hash Hash to verify.
        * @return bool True if the password matches the hash, False otherwise.
        */
    public static function verify($password, $hash)
    {
        //Apply the verification (hash computation options are included in the hash itself) and return the result
        return password_verify($password, $hash);
    }


    /**
     * Load Argon2 options to use for hashing.
     *
     * @return array A associative array with the options.
     */
    private static function loadParameters()
    {
        //Parse configuration file
        $options_array = parse_ini_file("config.ini");
        $memory = intval($options_array["MEMORY"]);
        $timeCost = intval($options_array["ITERATIONS"]);
        $parallelism = intval($options_array["PARALLELISM"]);
        if ($memory <= 0 || $timeCost <= 0 || $parallelism <= 0) {
            throw new Exception("One or more of the hashing configuration parameters are not valid values !");
        }
        //Create the options final arrays and return it
        return ["memory_cost" => $memory, "time_cost" => $timeCost, "threads" => $parallelism];
    }
}
