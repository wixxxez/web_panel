<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[UniqueEntity(
    fields: ['login'],
    errorPath: 'app_account_create',
    message: 'This login is already in use.',
)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $login = null;

    #[ORM\Column(length: 1000)]
    private ?string $password = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $cookies = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $event = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Date = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $barcode1 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $barcode2 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $Price = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $barcode3 = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $barcode4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Seats = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Price2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Seats2 = null;

    #[ORM\Column(length: 255, options: ["default" => 'Active'], nullable: true)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $worker_id = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $admin_event = null;

    #[ORM\Column(nullable: true)]
    private ?int $admin_id = null;

    #[ORM\Column(nullable: true)]
    private ?float $Sell = null;

    #[ORM\Column(nullable: true)]
    private ?float $Paid = null;

    #[ORM\Column(length: 255, options: ["default" => ""] )]
    private string $createdAt;

    public function __construct()
    {
        $this->createdAt = date('Y-m-d');
    }
 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCookies(): ?string
    {
        return $this->cookies;
    }

    public function setCookies(string $cookies): static
    {
        $this->cookies = $cookies;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(?string $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getBarcode1(): ?string
    {
        return $this->barcode1;
    }

    public function setBarcode1(?string $barcode1): static
    {
        $this->barcode1 = $barcode1;

        return $this;
    }

    public function getBarcode2(): ?string
    {
        return $this->barcode2;
    }

    public function setBarcode2(?string $barcode2): static
    {
        $this->barcode2 = $barcode2;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(?string $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getBarcode3(): ?string
    {
        return $this->barcode3;
    }

    public function setBarcode3(?string $barcode3): static
    {
        $this->barcode3 = $barcode3;

        return $this;
    }

    public function getBarcode4(): ?string
    {
        return $this->barcode4;
    }

    public function setBarcode4(?string $barcode4): static
    {
        $this->barcode4 = $barcode4;

        return $this;
    }

    public function getSeats(): ?string
    {
        return $this->Seats;
    }

    public function setSeats(?string $Seats): static
    {
        $this->Seats = $Seats;

        return $this;
    }

    public function getPrice2(): ?string
    {
        return $this->Price2;
    }

    public function setPrice2(?string $Price2): static
    {
        $this->Price2 = $Price2;

        return $this;
    }

    public function getSeats2(): ?string
    {
        return $this->Seats2;
    }

    public function setSeats2(?string $Seats2): static
    {
        $this->Seats2 = $Seats2;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getWorkerId(): ?int
    {
        return $this->worker_id;
    }

    public function setWorkerId(?int $worker_id): static
    {
        $this->worker_id = $worker_id;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $State): static
    {
        $this->state = $State;

        return $this;
    }

    public function getAdminEvent(): ?string
    {
        return $this->admin_event;
    }

    public function setAdminEvent(?string $admin_event): static
    {
        $this->admin_event = $admin_event;

        return $this;
    }

    public function getAdminId(): ?int
    {
        return $this->admin_id;
    }

    public function setAdminId(?int $admin_id): static
    {
        $this->admin_id = $admin_id;

        return $this;
    }

    public function getSell(): ?float
    {
        return $this->Sell;
    }

    public function setSell(?float $Sell): static
    {
        $this->Sell = $Sell;

        return $this;
    }

    public function getPaid(): ?float
    {
        return $this->Paid;
    }

    public function setPaid(?float $Paid): static
    {
        $this->Paid = $Paid;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $date): static
    {
        $this->createdAt = $date;

        return $this;
    }
   
}
