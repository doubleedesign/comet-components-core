<?php
namespace Doubleedesign\Comet\Core;

abstract class LayoutComponent extends UIComponent {
	use BackgroundColor;
	use LayoutAlignment;

	function __construct(array $attributes, array $children, string $bladeFile) {
		parent::__construct($attributes, $children, $bladeFile);
		$this->set_background_color_from_attrs($attributes);
		$this->set_layout_alignment_from_attrs($attributes);
	}

	protected function get_filtered_classes(): array {
		if($this instanceof Columns || $this instanceof Group) {
			return array_merge(
				['layout-block'],
				parent::get_filtered_classes()
			);
		}

		return parent::get_filtered_classes();
	}

	protected function get_html_attributes(): array {
		$attributes = parent::get_html_attributes();

		if(isset($this->hAlign)) {
			$attributes['data-halign'] = $this->hAlign->value;
		}

		if(isset($this->vAlign)) {
			$attributes['data-valign'] = $this->vAlign->value;
		}

		if(isset($this->backgroundColor)) {
			$attributes['data-background'] = $this->backgroundColor->value;
		}
		else if(isset($this->gradient)) {
			$attributes['data-background'] = 'gradient-' . $this->gradient;
		}

		return $attributes;
	}

	/**
	 * Default render method (child classes may override this)
	 *
	 * @return void
	 */
	public function render(): void {
		$blade = BladeService::getInstance();

		echo $blade->make($this->bladeFile, [
			'tag'        => $this->tagName->value,
			'classes'    => $this->get_filtered_classes_string(),
			'attributes' => $this->get_html_attributes(),
			'children'   => $this->innerComponents
		])->render();
	}
}
