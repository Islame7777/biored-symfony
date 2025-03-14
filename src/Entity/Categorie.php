<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomCategorie;

    // Le type de la colonne est une chaîne, donc nous allons stocker le nom de l'énumération dans la base de données.
    #[ORM\Column(type: 'string', length: 50)]
    private string $status;

    #[ORM\Column(type: 'text')]
    private $description;


 

   
    public function getId(): ?int
    {
        return $this->id;
    }
    // Getter et Setter pour 'status'
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
    

        $this->status = $status;
        return $this;
    }

    // Getter et Setter pour 'nomCategorie'
    public function getNomCategorie(): string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;
        return $this;
    }

    // Getter et Setter pour 'description'
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }


   

    

 

    
}
