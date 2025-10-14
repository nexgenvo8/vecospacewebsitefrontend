<?php
 
function authCustomer() {

    $params = array(new xmlrpcval(array("username"      => new xmlrpcval(get_par('name'), "string"),
                                      "password"      => new xmlrpcval(get_par('password'), "string")
									), 'struct'));
    $msg = new xmlrpcmsg('authCustomer', $params);

    /* replace here URL  and credentials to access to the API */
    $cli = new xmlrpc_client('https://208.43.27.85/xmlapi/xmlapi');
    $cli->setSSLVerifyPeer(false);
    $cli->setCredentials('ssp-root', 'a123456', CURLAUTH_DIGEST);

    $r = $cli->send($msg, 20);       /* 20 seconds timeout */

    if ($r->faultCode()) {
	
 echo "Fault. Code: " . $r->faultCode() . ", Reason: " . $r->faultString();
	
      error_log("Fault. Code: " . $r->faultCode() . ", Reason: " . $r->faultString());
      return false;
    }

    return $r->value();
}

  
  

?>