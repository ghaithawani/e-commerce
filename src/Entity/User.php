<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="first_name is required")
     */
    private ?string $first_name = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="last_name is required")
     */
    private ?string $last_name = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="email is required")
     */
    private ?string $email = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="role is required")
     */
    private ?string $role = null;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="password is required")
     */
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }
    public function getLastName(): ?string
    {
        return $this->last_name;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getRole(): ?string
    {
        return $this->role;
    }

}
