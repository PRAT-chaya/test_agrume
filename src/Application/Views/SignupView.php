<?php

namespace App\Application\Views;

use App\Application\Models\UserBuilder;
use App\Application\Models\User;

class SignupView extends View
{
    private $saveNewUserRoute;

    public function __construct(String $saveNewUserRoute)
    {
        parent::__construct();
        $this->saveNewUserRoute = $saveNewUserRoute;
    }

    private function getFormFields(UserBuilder $ub)
    {
        $namesFormFields = $this->getNamesFormFields($ub);
        $loginsFormFields = $this->getLoginsFormFields($ub);
        $statusFormField = $this->getStatusFormField($ub);
        $signatureFormField = $this->getSignatureFormField($ub);
        $professionalFormField = $this->getProfessionalFormField($ub);
        ob_start(); ?>
            <?=$namesFormFields?>
            <?=$loginsFormFields?>   
            <?=$statusFormField?>
            <?=$signatureFormField?>
            <?=$professionalFormField?>
            <div class="row mt-2">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Soumettre</button>
                </div>
            </div>
        <?php $formFields = ob_get_clean();
        return $formFields;
    }

    private function getNamesFormFields(UserBuilder $ub) 
    {
        $data = $ub->data;
        if($data === null) 
            $data = array();

        $firstNameRef = UserBuilder::FIRSTNAME_REF;
        $lastNameRef = UserBuilder::LASTNAME_REF;
        $usernameRef = UserBuilder::USERNAME_REF;

        $firstName = key_exists($firstNameRef, $data) ? $data[$firstNameRef] : null;
        $lastName = key_exists($lastNameRef, $data) ? $data[$lastNameRef] : null;
        $username = key_exists($usernameRef, $data) ? $data[$usernameRef] : null;
        ob_start(); ?>
        <div class="row">
            <div class="col-md-3">
                <label for="<?=$firstNameRef?>" class="form-label">Prénom</label>
                <input type="text" class="form-control" 
                id="<?=$firstNameRef?>"
                name="<?=$firstNameRef?>" 
                value="<?php if($firstName !== null) echo htmlspecialchars($firstName);?>"
                required>
                <?=$this->getFeedBack($ub, $firstNameRef) ?>
            </div>
            <div class="col-md-3">
                <label for="<?=$lastNameRef?>" class="form-label">Nom</label>
                <input type="text" class="form-control"
                id="<?=$lastNameRef?>" 
                name="<?=$lastNameRef?>" 
                value="<?php if($lastName !== null) echo htmlspecialchars($lastName);?>"
                required>
                <?=$this->getFeedBack($ub, $lastNameRef) ?>
            </div>
            <div class="col-md-3">
                <label for="<?=$usernameRef?>" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="<?=$usernameRef?>" name="<?=$usernameRef?>" value="<?php if($username !== null) echo htmlspecialchars($username);?>">
                <?=$this->getFeedBack($ub, $usernameRef) ?>
            </div>
        </div>
        <?php $namesFormFields = ob_get_clean();
        return $namesFormFields;
    }

    private function getLoginsFormFields(UserBuilder $ub)
    {
        $data = $ub->data;
        if($data === null) 
            $data = array();

        $emailAddrRef = UserBuilder::EMAILADDR_REF;
        $passwordRef = UserBuilder::PASSWORD_REF;
        $emailAddr = key_exists($emailAddrRef, $data) ? $data[$emailAddrRef] : null;

        ob_start();?>
        <div class="row mt-2">
            <div class="col-md-5">
                <label for="<?=$emailAddrRef?>" class="form-label">Adresse email</label>
                <input type="email" class="form-control" 
                name="<?=$emailAddrRef?>" 
                id="<?=$emailAddrRef?>"
                value="<?php if($emailAddr !== null) echo htmlspecialchars($emailAddr);?>"
                required>
                <?=$this->getFeedBack($ub, $emailAddrRef) ?>
            </div>
            <div class="col-md-4">
                <label for="<?=$passwordRef?>" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="<?=$passwordRef?>"
                required>
                <?=$this->getFeedBack($ub, $passwordRef) ?>
            </div>
        </div>
        <?php $loginsFormFields = ob_get_clean();
        return $loginsFormFields;
    }

    private function getStatusFormField(UserBuilder $ub)
    {
        $data = $ub->data;
        if($data === null) 
            $data = array();

        $statusRef = UserBuilder::STATUS_REF;
        $status = key_exists($statusRef, $data) ? $data[$statusRef] : null;
        $validStatus = User::VALID_STATUS;

        ob_start();?>
        <div class="row mt-2">
            <div class="col-md-5">
                <label for="<?=$statusRef?>" class="form-label">Statut</label>
                <select name="<?=$statusRef?>" class="custom-select" required>
                    <option <?php if($status === null) echo 'selected'?>>
                        Choisissez une catégorie...
                    </option>
                    <option <?php if($status === $validStatus[0]) echo 'selected';?>>
                        <?=$validStatus[0]?>
                    </option>
                    <option <?php if($status === $validStatus[1]) echo 'selected';?>>
                        <?=$validStatus[1]?>
                    </option>
                    <option <?php if($status === $validStatus[2]) echo 'selected'?>>
                        <?=$validStatus[2]?>
                    </option>
                    <option <?php if($status === $validStatus[3]) echo 'selected'?>>
                        <?=$validStatus[3]?>
                    </option>
                    <option <?php if($status === $validStatus[4]) echo 'selected'?>>
                        <?=$validStatus[4]?>
                    </option>
                </select>
            </div>
            <?=$this->getFeedBack($ub, $statusRef) ?>
        </div>
        <?php $statusFormField = ob_get_clean();
        return $statusFormField;
    }

    private function getSignatureFormField(UserBuilder $ub)
    {
        $data = $ub->data;
        if($data === null) 
            $data = array();

        $signatureRef = UserBuilder::SIGNATURE_REF;
        $signature = key_exists($signatureRef, $data) ? $data[$signatureRef] : null;

        ob_start();?>
        <div class="row mt-2">
            <div class="col-md-9">
                <label for="<?=$signatureRef?>" class="form-label">Signature</label>
                <textarea class="form-control" id="<?=$signatureRef?>" name="<?=$signatureRef?>" rows="3"><?php 
                    if($signature !== null) echo htmlspecialchars($signature);
                ?></textarea>
                <?=$this->getFeedBack($ub, $signatureRef) ?>
            </div>
        </div>
        <?php $signatureFormField = ob_get_clean();
        return $signatureFormField;
    }

    private function getProfessionalFormField(UserBuilder $ub)
    {
        $data = $ub->data;
        if($data === null) 
            $data = array();

        $professionalRef = UserBuilder::PROFESSIONAL_REF;
        $professional = isset($data[$professionalRef]);

        ob_start();?>
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        name="<?=$professionalRef?>"
                        <?php if($professional===true) echo "checked"?>
                    >
                    <label class="form-check-label" for="<?=$professionalRef?>">Ceci est un compte professionnel</label>
                </div>
                <?=$this->getFeedBack($ub, $professionalRef) ?>
            </div>
        </div>
        <?php $professionalFormField = ob_get_clean();

        return $professionalFormField;
    }

    private function getFeedBack(UserBuilder $ub, String $ref) 
    {
        if(!$ub->isValid())
        {
            $error = $ub->getError($ref);
            if($error !== null)
                return '<div class="feedback alert alert-danger">' . $error . '</div>';

            return "";
        }
    }

    public function makeSignupForm(UserBuilder $ub)
    {
        $this->content = "";
        if(!$ub->isValid()) {
            $this->content .= '<h3 class="alert alert-danger">Erreur dans le formulaire</h3>';
        }
        $this->title = "Formulaire d'inscription";
        $this->content .= '<div class="container">';
        $this->content .= '<form class="needs-validation" action="' . $this->saveNewUserRoute . '" method="POST">';
        $this->content .= $this->getFormFields($ub);
        $this->content .= "</form></div>";
        $this->content .= '<script>' . $this->jsFormValidator() . '</script>';
    }

    public function makeSuccessfulSignupPage($id, User $user)
    {
        $this->title = "Inscription réussie !";
        if($user->isProfessional())
        {
            $this->content = $this->makeProPage($id,$user);
        }
        else if(!$user->isProfessional())
        {
            $this->content = $this->makeCasualpage($id, $user);
        }
    }

    private function makeProPage($id, User $user)
    {
        $content = '<div class="container">';
        $content .= '<p>Version professionnelle </p>';
        ob_start();?>
        <div class="jumbotron">
            <p>id: <?=$id?></p>
            <p>Prénom: <?=$user->getFirstName()?></p>
            <p>Nom de famille: <?=$user->getLastName()?></p>
            <p>Adresse mail: <?=$user->getEmailAddr()?></p>
            <p>Statut: <?php if($user->getStatus() !== null) echo $user->getStatus();?></p>
            <p>Signature: <?php if($user->getSignature() !== null) echo htmlspecialchars($user->getSignature());?></p>
        </div>
        <?php $content .= ob_get_clean();
        $content .= '</div>';
        return $content;
    }

    private function makeCasualPage($id, User $user)
    {
        $content = '<div class="container">';
        $content .= '<p>Version pas professionnelle </p>';
        ob_start();?>
        <div class="jumbotron">
            <p>Pseudo: <?php if($user->getUsername() !== null) echo $user->getUsername();?></p>
            <p>Prénom: <?=$user->getFirstName()?></p>
            <p>Nom de famille: <?=$user->getLastName()?></p>
            <p>Statut: <?php if($user->getStatus() !== null) echo $user->getStatus();?></p>
            <p>Signature: <?php if($user->getSignature() !== null) echo htmlspecialchars($user->getSignature());?></p>
        </div>
        <?php $content .= ob_get_clean();
        $content .= '</div>';
        return $content;
    }

    private function jsFormValidator()
    {
        ob_start()?>
            const NAME_BANNED_CHARS = [
                "<",">",",","?", ";", ".", ":", "/", "§",
                "!","#","{", "}", "(", ")", "[", "]",
                "|", "`", "'", '"', "\\", "^", "°",
                "+", "=", "*", "%", "~"
            ];

            let firstNameInput = document.getElementById("<?=UserBuilder::FIRSTNAME_REF?>");
            let lastNameInput = document.getElementById("<?=UserBuilder::LASTNAME_REF?>");
            let usernameInput = document.getElementById("<?=UserBuilder::USERNAME_REF?>");
            let emailAddrInput = document.getElementById("<?=UserBuilder::EMAILADDR_REF?>");
            let signatureInput = document.getElementById("<?=UserBuilder::SIGNATURE_REF?>");

            firstNameInput.addEventListener('input', function(e) {
                validateName(e.target);
            });
            lastNameInput.addEventListener('input', function(e) {
                validateName(e.target);
            });
            usernameInput.addEventListener('input', function(e) {
                validateName(e.target);
            });


            function validateName(element){
                element.nextSibling.remove();
                NAME_BANNED_CHARS.forEach(
                    (c) => {
                        if(element.value.includes(c)){
                            element.insertAdjacentHTML('afterend', "<span>Caractères non autorisés</span>");
                        }
                    }
                );
            }
        <?php return ob_get_clean();
    }
}