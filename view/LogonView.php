<?php

class LogonView {
	
	public function showLoginPage() {

		$ret = "
<div id='gConnect' class='button'>
    <button class='g-signin'
      data-scope='email'
      data-clientid='1007777563828-qf7sfjkv028b4ir0e3sk6slc1kji3m9q.apps.googleusercontent.com'
      data-callback='onSignInCallback'
      data-theme='dark'
      data-cookiepolicy='single_host_origin'>
    </button>
</div>
		";

		return $ret;
	}
}