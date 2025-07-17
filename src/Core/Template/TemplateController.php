<?php declare(strict_types=1);

namespace Perfin\Core\Template;

use \League\Plates\Engine;
use \League\Plates\Template\Theme;

class TemplateController {
  public Engine $engine;

  public function __construct() {
    $this->engine = Engine::fromTheme(Theme::hierarchy([
      Theme::new(TEMPLATES_DIR . '/default', 'Default')
    ]));
    $this->engine->setFileExtension('phtml');
  }
}