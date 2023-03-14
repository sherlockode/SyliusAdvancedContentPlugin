<?php

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
    /**
     * @var ConfigurationManager
     */
    private $configurationManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ScopeInitializer
     */
    private $scopeInitializer;

    /**
     * @param ConfigurationManager $configurationManager
     * @param TranslatorInterface  $translator
     * @param ScopeInitializer     $scopeInitializer
     * @param                      $name
     */
    public function __construct(
        ConfigurationManager $configurationManager,
        TranslatorInterface $translator,
        ScopeInitializer $scopeInitializer,
        $name = null
    ) {
        parent::__construct($name);
        $this->configurationManager = $configurationManager;
        $this->translator = $translator;
        $this->scopeInitializer = $scopeInitializer;
    }

    protected function configure()
    {
        $this
            ->setName('sherlockode:sylius-acb:init-scope')
            ->setDescription('Initialize sylius scopes for ACB')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->configurationManager->isScopesEnabled()) {
            $io->info($this->translator->trans('sherlockode_sylius_acb.scopes.disabled'));

            if (defined(sprintf('%s::SUCCESS', get_class($this)))) {
                return self::SUCCESS;
            }
            return;
        }
        if (!$this->scopeInitializer->hasMissingScopes()) {
            $io->info($this->translator->trans('sherlockode_sylius_acb.scopes.up_to_date'));

            if (defined(sprintf('%s::SUCCESS', get_class($this)))) {
                return self::SUCCESS;
            }
            return;
        }

        try {
            $this->scopeInitializer->init();
            $io->success($this->translator->trans('sherlockode_sylius_acb.scopes.init_success'));
            if (defined(sprintf('%s::SUCCESS', get_class($this)))) {
                return self::SUCCESS;
            }
            return;
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            if (defined(sprintf('%s::FAILURE', get_class($this)))) {
                return self::FAILURE;
            }
        }
    }
}
