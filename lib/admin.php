<?php
namespace OCA\Zenodo;

$app = new \OCA\Zenodo\AppInfo\Application();

$response = $app->getContainer()
				->query('SettingsController')
				->admin();

return $response->render();
