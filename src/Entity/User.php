<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User //implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;



    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $DNI;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $perfil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $estudios;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $antecedentes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $formacion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, nullable=true)
     */
    private $diploma;

    /**
     * @ORM\ManyToMany(targetEntity=role::class, inversedBy="users")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDNI(): ?int
    {
        return $this->DNI;
    }

    public function setDNI(int $DNI): self
    {
        $this->DNI = $DNI;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getPerfil(): ?string
    {
        return $this->perfil;
    }

    public function setPerfil(string $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }

    public function getEstudios(): ?string
    {
        return $this->estudios;
    }

    public function setEstudios(string $estudios): self
    {
        $this->estudios = $estudios;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getAntecedentes(): ?string
    {
        return $this->antecedentes;
    }

    public function setAntecedentes(string $antecedentes): self
    {
        $this->antecedentes = $antecedentes;

        return $this;
    }

    public function getFormacion(): ?string
    {
        return $this->formacion;
    }

    public function setFormacion(string $formacion): self
    {
        $this->formacion = $formacion;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getDiploma(): ?string
    {
        return $this->diploma;
    }

    public function setDiploma(?string $diploma): self
    {
        $this->diploma = $diploma;

        return $this;
    }

    /**
     * @return Collection|role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function getRolesObjects() {
        return $this->roles;
    }

    public function addRole(role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }
}
