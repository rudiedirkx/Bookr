<?php

namespace rdx\bookr;

class Label extends UserModel {

	static public $_table = 'labels';

	static protected $allSorted;



	protected function relate_category() {
		return $this->to_one(Category::class, 'category_id');
	}

	protected function relate_num_books() {
		return $this->to_count('books_labels', 'label_id');
	}



	static public function names( array $ids, Category $category = null ) {
		$all = self::allSorted();
		if ( $category ) {
			$all = array_filter($all, function(Label $label) use ($category) {
				return $label->category_id == $category->id;
			});
		}
		$enabled = array_intersect_key($all, array_flip($ids));
		return self::options($enabled);
	}

	static public function allSorted( $withDisabled = false ) {
		if ( self::$allSorted === null ) {
			$enabled = $withDisabled ? '1' : "enabled = '1'";
			self::$allSorted = self::all("$enabled ORDER BY (SELECT weight FROM categories WHERE id = category_id), weight");
		}

		return self::$allSorted;
	}



	public function __toString() {
		return (string) $this->name;
	}

}
