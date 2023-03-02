<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=13)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    private $overview;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $picture;

    /**
     * @Assert\Image(mimeTypes={"image/jpeg", "image/png"})
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $readCount = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function setPictureFilename(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->picture;
    }

    public function setPictureFile(?File $pictureFile = null): self
    {
        $this->picture = $pictureFile;

        if ($pictureFile !== null) {
            $this->setUpdatedAt(new \DateTime());
        }

        return $this;
    }

    public function uploadPicture()
    {
        if ($this->pictureFile !== null) {
            $newFilename = uniqid().'.'.$this->pictureFile->getClientOriginalExtension();

            $this->pictureFile->move(
                $this->getPictureDirectory(),
                $newFilename
            );

            $this->setPictureFilename($newFilename);
        }
    }

    public function getPicturePath(): ?string
    {
        if ($this->pictureFilename === null) {
            return null;
        }

        return $this->getPictureDirectory().'/'.$this->pictureFilename;
    }

    public function getPictureDirectory(): string
    {
        return 'uploads/pictures';
    }

    public function getReadCount(): ?int
    {
        return $this->readCount;
    }

    public function setReadCount(?int $readCount = 1): self
    {
        if($readCount == "" || $readCount = " "){
            $this->readCount = 1;
        }
        else{
            $this->readCount = $readCount;
        }
        return $this;
    }
}
