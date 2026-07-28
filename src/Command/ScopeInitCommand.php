<?php

declare(strict_types=1);

namespace Sherlockode\SyliusAdvancedContentPlugin\Command;

use Sherlockode\AdvancedContentBundle\Manager\ConfigurationManager;
use Sherlockode\SyliusAdvancedContentPlugin\Scope\ScopeInitializer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScopeInitCommand extends Command
{
    public function __construct(
        private readonly ConfigurationManager $configurationManager,
        private readonly TranslatorInterface $translator,
        private readonly ScopeInitializer $scopeInitializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('sherlockode:sylius-acb:init-scope')
            ->setDescription('Initialize sylius scopes for ACB')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->configurationManager->isScopesEnabled()) {
            $io->info($this->translator->trans('sherlockode_sylius_acb.scopes.disabled'));

            return self::SUCCESS;
        }

        if (!$this->scopeInitializer->hasMissingScopes()) {
            $io->info($this->translator->trans('sherlockode_sylius_acb.scopes.up_to_date'));

            return self::SUCCESS;
        }

        try {
            $this->scopeInitializer->init();
            $io->success($this->translator->trans('sherlockode_sylius_acb.scopes.init_success'));

            return self::SUCCESS;
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
