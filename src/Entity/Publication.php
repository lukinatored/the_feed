<?php

// src/Entity/Publication.php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    
    #[Assert\NotNull(message: 'Le champ ne peut pas être vide.')]
    #[Assert\NotBlank(message: 'Le champ ne peut pas être laissé vide.')]
    #[Assert\Length(
        min: 4,
        max: 200,
        minMessage: 'Le message doit contenir au moins 4 caractères.',
        maxMessage: 'Le message ne doit pas dépasser 200 caractères.'
    )]
    private ?string $message = null;
    
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
      #[ORM\PrePersist]
    public function prePersistDatePublication(): void
    {
        if ($this->date === null) {
            $this->date = new \DateTime();
        }
    }

   private $name;


   public function getName(): ?string
   {
       return $this->name;
   }


   public function setName(string $name): self
   {
       $this->name = $name;

       return $this;
   }

  private $author;


  public function getAuthor(): ?string
  {
      return $this->author;
  }

  public function setAuthor(string $author): self
  {
      $this->author = $author;
      return $this;
  }
  public function getChamp1(): ?string
  {
      return $this->message;
  }

  public function setChamp1(?string $message): self
  {
      $this->message = $message;

      return $this;
      
}

}
