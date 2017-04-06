<?php
namespace Botanist;


class Comment
{
	/**
	 * @param mixed $source
	 * @return string
	 */
	public static function get($source): string
	{
		if ($source instanceof \Reflector)
		{
			if (!method_exists($source, 'getDocComment'))
			{
				throw new \Exception('Unexpected object type');
			}
			
			return $source->getDocComment();
		}
		else if (is_callable($source))
		{
			if (is_string($source) && function_exists($source))
			{
				return self::get(new \ReflectionFunction($source));
			}
			else if (is_array($source))
			{
				return self::get(new \ReflectionMethod(...$source));
			}
			else 
			{
				return self::get(new \ReflectionMethod($source));
			}
		}
		else if (is_object($source))
		{
			return self::get(new \ReflectionClass($source));
		}
		else if (is_string($source) && class_exists($source))
		{
			return self::get(new \ReflectionClass($source));
		}
	}
}