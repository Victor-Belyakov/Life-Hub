<?php
namespace console\rbac;

use yii\rbac\ManagerInterface;

interface RoleInterface
{
    /**
     * @param ManagerInterface $auth
     * @return void
     */
    public function create(ManagerInterface $auth): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return array
     */
    public function getChildrenRoles(): array;

    /**
     * @return array
     */
    public function getPermissions(): array;
}
