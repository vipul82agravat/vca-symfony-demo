<?php 

 namespace App\Enitiy;

 use Doctrine\Common\Collections\ArrayCollection;
 use Doctrine\ORM\Mapping as ORM;

 #[ORM\Table(name: "categories")]
 class Categories
 {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Categories::class, mappedBy: 'parent')]
    private Collection $children;
    
    #[ORM\OneToMany(mappedBy: 'children', targetEntity: Categories::class)]
    private Collection $parent;
   

    public function __construct($name)
    {
        $this->children = new ArrayCollection();
        $this->name=$name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): viod
    {
        $this->name = $name;

        return $this;
    }
    public function getchildren()
    {
        return $this->children;
    }
    
    public function setchildren($children): viod
    {
        return $this->children=$children;

       
    }
    public function addChild(Categories $child){
        if(!$this->children->contains($child)){
            $this->children[]=$child;
        }
    }
    public function getparent()
    {
        return $this->parent;
    }
    
    public function setparent(Categories $parent): viod
    {
        $parent->addChild($this  );
        return $this->parent=$parent;

       
    }
}