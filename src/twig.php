<?php

	namespace outsideperspective;
	use Twig\Extra\Markdown\DefaultMarkdown;
	use Twig\Extra\Markdown\MarkdownRuntime;
	use Twig\Extra\Markdown\MarkdownExtension;
	use Twig\RuntimeLoader\RuntimeLoaderInterface;
	
	
	class twig {
		function __construct(){
			$loader = new \Twig\Loader\FilesystemLoader( 
				conf::root_path . '/templates'
			);
	
			
			$this->twig = new \Twig\Environment($loader,
			[	
				'cache' => false
			]);	
			
			/*$this->twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
				public function load($class) {
					if (MarkdownRuntime::class === $class) {
						return new MarkdownRuntime(new DefaultMarkdown());
					}
				}
			});
			$this->twig->addExtension(new MarkdownExtension());
			*/
					
		}
	
		function render( $path, $data=[] ) {
			return $this->twig->render($path, $data);
		}
	
		function put( $path, $data=[] ) {
			print $this->twig->render($path, $data);
		}
		
	
	
	}