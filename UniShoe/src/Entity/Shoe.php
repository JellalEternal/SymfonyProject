<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoeRepository")
 * @Vich\Uploadable()
 */
class Shoe
{
    const CHOICES_STATE = [
        '0' => 'Jamais utilisée',
        '1' => 'Très bon état',
        '2' => 'Bon état',
        '3' => 'Mauvais état',
        '4' => 'Très mauvais état'
    ];

    const INSTOCK = [
        '0' => 'Vendu',
        '1' => 'Disponible',
    ];

    const CHOICES_TYPE = [
        '0' => 'Ballerines',
        '1' => 'Bottes',
        '2' => 'Baskets',
        '3' => 'Chaussure à lacet',
        '4' => 'Chaussure de sport',
        '5' => 'Chaussure de travail',
    ];

    const CHOICES_SIDE = [
        '0' => 'Gauche',
        '1' => 'Droite'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stock;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mark;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shoes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="integer")
     */
    private $side;

    /**
     * @ORM\Column(type="integer")
     */
    private $shoe_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $labelUser;
    
    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getSlug(): string
    {
        $slugString = new Slugify();
        return $slugString->slugify($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?bool
    {
        return $this->stock;
    }

    public function setStock(bool $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStockType(): string
    {
        return self::INSTOCK[$this->stock];
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getStateType(): string
    {
        return self::CHOICES_STATE[$this->shoe_type];
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getSide(): ?int
    {
        return $this->side;
    }

    public function setSide(int $side): self
    {
        $this->side = $side;

        return $this;
    }

    public function getSideType(): ?string
    {
        return self::CHOICES_SIDE[$this->side];
    }

    public function getShoeType(): ?int
    {
        return $this->shoe_type;
    }

    public function setShoeType(int $shoe_type): self
    {
        $this->shoe_type = $shoe_type;

        return $this;
    }

    public function getLabelUser(): ?string
    {
        return $this->labelUser;
    }

    public function setLabelUser(string $labelUser): self
    {
        $this->labelUser = $labelUser;

        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): Shoe
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
     */
    private $imagefile;

    public function getImageFile()
    {
        return $this->imagefile;
    }

    /**
     * @param null|File $imagefile
     * @return Shoe
     * @throws Exception
     */
    public function setImageFile(?File $imagefile): Shoe
    {
        $this->imagefile = $imagefile;
        if($this->imagefile instanceof UploadedFile){
            $this->created_at = new \DateTime('now');
        }
        return $this;
    }
}
