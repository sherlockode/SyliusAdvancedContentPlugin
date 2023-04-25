<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filter\StringFilter;
use Sylius\Component\Grid\Filtering\FilterInterface;

class PageTitleFilter implements FilterInterface
{
    public function apply(DataSourceInterface $dataSource, $name, $data, array $options = []): void
    {
        $restriction = null;

        if (StringFilter::TYPE_CONTAINS === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->like('pageMetas.title', '%' . $data['value'] . '%');
        } elseif (StringFilter::TYPE_NOT_CONTAINS === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->notLike('pageMetas.title', '%' . $data['value'] . '%');
        } elseif (StringFilter::TYPE_EQUAL === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->equals('pageMetas.title', $data['value']);
        } elseif (StringFilter::TYPE_NOT_EQUAL === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->notEquals('pageMetas.title', $data['value']);
        } elseif (StringFilter::TYPE_EMPTY === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->isNull('pageMetas.title');
        } elseif (StringFilter::TYPE_NOT_EMPTY === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->isNotNull('pageMetas.title');
        } elseif (StringFilter::TYPE_STARTS_WITH === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->like('pageMetas.title', $data['value'] . '%');
        } elseif (StringFilter::TYPE_ENDS_WITH === $data['type']) {
            $restriction = $dataSource->getExpressionBuilder()->like('pageMetas.title', '%' . $data['value']);
        }

        if ($restriction) {
            $dataSource->restrict($restriction);
        }
    }
}
