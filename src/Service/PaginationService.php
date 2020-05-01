<?php


namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaginationService
{
    private $generateUrl;

    public function __construct(UrlGeneratorInterface $generateUrl)
    {
        $this->generateUrl = $generateUrl;
    }

    public function linkPagination(int $page, int $totalPrduit, string $list)
    {
        $numberPage = 0;
        $tabLinkPagignation = [];

        if ($page > 0) {
            $tabLinkPagignation = array_merge($tabLinkPagignation, ["Previous page" => $this->generateUrl->generate($list, ["page" => $numberPage = $page / 5 - 1], UrlGeneratorInterface::ABSOLUTE_URL)]);
        }
        if ($page + 5 <= $totalPrduit) {
            $tabLinkPagignation = array_merge($tabLinkPagignation, ["Next page" => $this->generateUrl->generate($list, ["page" => $numberPage = $page / 5 + 1], UrlGeneratorInterface::ABSOLUTE_URL)]);
        }

        return $tabLinkPagignation;
    }


}