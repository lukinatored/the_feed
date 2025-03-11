<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Le titre ne peut pas être vide.')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Le titre doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $title = null;

    
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide.')]
    #[Assert\Length(
        min: 5,
        max: 5000,
        minMessage: 'Le contenu doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le contenu ne peut pas dépasser {{ limit }} caractères.'
    )]
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

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
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
