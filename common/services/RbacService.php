<?php

use yii\rbac\ManagerInterface;

class RbacService
{
    private ManagerInterface $auth;
    private array $config;

    public function __construct(ManagerInterface $auth = null, string $configFile = null)
    {
        $this->auth = $auth ?? Yii::$app->authManager;
        $this->config = $configFile ? require $configFile : [];
    }

    public function initRbac(): void
    {
        $this->auth->removeAll();

        foreach ($this->config['permissions'] ?? [] as $name => $description) {
            $permission = $this->auth->createPermission($name);
            $permission->description = $description;
            $this->auth->add($permission);
        }

        $roles = [];
        foreach ($this->config['roles'] ?? [] as $roleName => $roleData) {
            $role = $this->auth->createRole($roleName);
            $this->auth->add($role);
            $roles[$roleName] = $role;
        }

        foreach ($this->config['roles'] ?? [] as $roleName => $roleData) {
            $role = $roles[$roleName];

            foreach ($roleData['permissions'] ?? [] as $permName) {
                $permission = $this->auth->getPermission($permName);
                if ($permission) {
                    $this->auth->addChild($role, $permission);
                }
            }

            foreach ($roleData['inherits'] ?? [] as $parentRoleName) {
                if (isset($roles[$parentRoleName])) {
                    $this->auth->addChild($role, $roles[$parentRoleName]);
                }
            }
        }

        foreach ($this->config['assignments'] ?? [] as $userId => $roleName) {
            if (isset($roles[$roleName])) {
                $this->auth->assign($roles[$roleName], $userId);
            }
        }
    }
}