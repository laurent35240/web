<?php

namespace AppBundle\Association\Model;

use AppBundle\Validator\Constraints as AppAssert;
use CCMBenchmark\Ting\Entity\NotifyProperty;
use CCMBenchmark\Ting\Entity\NotifyPropertyInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @AppAssert\UniqueEntity(fields={"username"}, repository="\AppBundle\Association\Model\Repository\UserRepository")
 * @AppAssert\UniqueEntity(fields={"email"}, repository="\AppBundle\Association\Model\Repository\UserRepository")
 */
class User implements NotifyPropertyInterface, UserInterface, \Serializable
{
    use NotifyProperty;

    const LEVEL_MEMBER = 0;
    const LEVEL_WRITER = 1;
    const LEVEL_ADMIN = 2;

    const STATUS_PENDING = -1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $companyId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $level = self::LEVEL_MEMBER;

    /**
     * @var int
     */
    private $levelModules = '00000';

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @var string
     */
    private $civility;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country = 'FR';

    /**
     * @var string
     */
    private $phone;

    /**
     * @var int
     */
    private $status = 0;

    /**
     * @var \DateTime
     */
    private $reminderDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->propertyChanged('id', $this->id, $id);
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param int $companyId
     * @return User
     */
    public function setCompanyId($companyId)
    {
        $this->propertyChanged('companyId', $this->companyId, $companyId);
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->propertyChanged('username', $this->username, $username);
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->propertyChanged('password', $this->password, $password);
        $this->password = $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return User
     */
    public function setLevel($level)
    {
        $this->propertyChanged('level', $this->level, $level);
        $this->level = $level;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevelModules()
    {
        return $this->levelModules;
    }

    /**
     * @param int $levelModules
     * @return User
     */
    public function setLevelModules($levelModules)
    {
        $this->propertyChanged('levelModules', $this->levelModules, $levelModules);
        $this->levelModules = $levelModules;
        return $this;
    }

    /**
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     * @return User
     */
    public function setCivility($civility)
    {
        $this->propertyChanged('civility', $this->civility, $civility);
        $this->civility = $civility;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->propertyChanged('firstName', $this->firstName, $firstName);
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->propertyChanged('lastName', $this->lastName, $lastName);
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->propertyChanged('email', $this->email, $email);
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->propertyChanged('address', $this->address, $address);
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->propertyChanged('zipCode', $this->zipCode, $zipCode);
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->propertyChanged('city', $this->city, $city);
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->propertyChanged('country', $this->country, $country);
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->propertyChanged('phone', $this->phone, $phone);
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->propertyChanged('status', $this->status, $status);
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReminderDate()
    {
        return $this->reminderDate;
    }

    /**
     * @param \DateTime $reminderDate
     * @return User
     */
    public function setReminderDate(\DateTime $reminderDate = null)
    {
        $this->propertyChanged('reminderDate', $this->reminderDate, $reminderDate);
        $this->reminderDate = $reminderDate;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $defaultRoles = ['ROLE_USER'];
        if ($this->level == self::LEVEL_ADMIN) {
            $defaultRoles[] = 'ROLE_SUPER_ADMIN';
        }

        return array_unique(array_merge($this->roles, $defaultRoles));
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles = null)
    {
        if ($roles === null) {
            $roles = [];
        }
        $this->propertyChanged('roles', $this->roles, $roles);
        $this->roles = $roles;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize(['id' => $this->id]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        $array = unserialize($serialized);
        $this->id = $array['id'];
    }
}