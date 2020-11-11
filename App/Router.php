<?php

namespace App;

use App\DATA;

class Router
{
	private function getRoutes()
	{
		return include_once(DATA::ROUTES);
	}

	private function getUri()
	{
		if(!empty($_SERVER['REQUEST_URI'])) {
			return trim(strip_tags($_SERVER['REQUEST_URI']),"/");
		}
	}

	public function __construct()
	{
		$uri = $this->getUri();

		foreach($this->getRoutes() as $uriPattern => $path) {
			if(preg_match("~$uriPattern~", $uri)) {
				$innerPath = preg_replace("~$uriPattern~", $path, $uri);
				$segments = explode("/", $innerPath);
				$controllerName = ucfirst(array_shift($segments))."Controller";
				$actionName = "action".ucfirst(array_shift($segments));
				$param = $segments;
				$controllerFile = ROOT.'/App/Controllers/'.$controllerName.'.php';

				if(file_exists($controllerFile)) {
					include_once($controllerFile);
				} else {
					header("Location: /");
				}

				if(!method_exists($controllerName, $actionName)) {
					header("Location: /");
				}

				$controllerObj = new $controllerName;
				$result = call_user_func_array(array($controllerObj, $actionName), $param);
				if($result != false) {
					break;
				}
			}
		}











	}


}