<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerCrknBAG\Academy_App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerCrknBAG/Academy_App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerCrknBAG.legacy');

    return;
}

if (!\class_exists(Academy_App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerCrknBAG\Academy_App_KernelDevDebugContainer::class, Academy_App_KernelDevDebugContainer::class, false);
}

return new \ContainerCrknBAG\Academy_App_KernelDevDebugContainer([
    'container.build_hash' => 'CrknBAG',
    'container.build_id' => 'bf005453',
    'container.build_time' => 1610916329,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerCrknBAG');
