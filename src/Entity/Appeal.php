<?php

namespace App\Entity;

use App\Repository\AppealRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AppealRepository::class)
 */
class Appeal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *      max = 256,
     *      maxMessage = "Длина имени должна быть не более {{ limit }} символов"
     *      )
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $customer;

    /**
     * @Assert\NotBlank(
     *     message="Укажите телефон"
     *     )
     * @Assert\Regex(
     *     "#\+(7)\(\d{3}\)\d{3}-\d{2}-\d{2}$#",
     *     message="Укажите корректный телефон"
     *     )
     * @ORM\Column(type="string", length=16)
     */
    private $phone;

    /**
     * @Assert\Choice({0, 1, 2})
     * @ORM\Column(type="integer", columnDefinition="ENUM(0, 1, 2)", options={"default":0})
     */
    private $status = 0;

    public const STATUS_NAMES = [
            0 => 'На модерации',
            1 => 'Обработана',
            2 => 'Отклонена'
        ];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(?string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getStatusName(): ?string
    {
        return self::STATUS_NAMES[$this->status];
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
