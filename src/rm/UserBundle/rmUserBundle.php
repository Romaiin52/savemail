<?php

namespace rm\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class rmUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
