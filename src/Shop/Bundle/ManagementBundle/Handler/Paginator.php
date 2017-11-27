<?php
namespace Shop\ManagementBundle\Paginator;

class Paginator
{
    protected $ppp; // Posts Per Page
    
    protected $nor; // Number Of Articles to paginate (not always articles from a specific shop,
                    // maybe from search maybe from filter)
    
    public function __construct($ppp,$nor) {
        $this->$ppp= $ppp;
        $this->$nor= $nor;
    }
    
    public function getNumberOfPages()
    {
        return ceil($this->nor/ $this->ppp);
        
    }
}
