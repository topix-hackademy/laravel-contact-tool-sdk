<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Contracts;

interface iReferable
{
    // Create Local Reference
    public function createReference($id, $name);
    // Update Local Reference
    public function updateReference($id, $name);
    // Reurn loacal Reference
    public function getLocalReference();
    // Check if local reference already exist
    public function checkIfLocalExist();

}