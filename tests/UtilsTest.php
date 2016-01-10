<?php
/**
 * Util Class
 *
 * @category    PHP
 * @package     WpWodify
 * @subpackage  Util
 * @since       File available since release 1.0.x
 * @author      Cory Collier <corycollier@corycollier.com>
 */

namespace PhpString;

/**
 * Util Class
 *
 * @category    PHP
 * @package     WpWodify
 * @subpackage  Util
 * @since       Class available since release 1.0.x
 * @author      Cory Collier <corycollier@corycollier.com>
 */
class UtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the Constructor
     */
    public function testConstructor()
    {
        $string = 'string';
        $separators = ['key' => 'value'];
        $sut = new Utils($string, $separators);

        $property = new \ReflectionProperty('\PhpString\Utils', 'string');
        $property->setAccessible(true);
        $result = $property->getValue($sut);
        $this->assertEquals($string, $result);

        $property = new \ReflectionProperty('\PhpString\Utils', 'separators');
        $property->setAccessible(true);
        $result = $property->getValue($sut);
        $this->assertEquals($separators, $result);
    }

    /**
     * Tests PhpString\Utils::humanify
     *
     * @dataProvider provideHumanify
     */
    public function testHumanify($expected, $input, $replacements)
    {
        $sut = $this->getMockBuilder('\PhpString\Utils')
            ->setConstructorArgs([$input])
            ->setMethods(['buildAssociativeArrayOfSeparators'])
            ->getMock();

        $sut->expects($this->once())
            ->method('buildAssociativeArrayOfSeparators')
            ->with($this->equalTo(' '))
            ->will($this->returnValue($replacements));

        $result = $sut->humanify();
        // $this->assertSame($sut, $result);

        $property = new \ReflectionProperty('\PhpString\Utils', 'string');
        $property->setAccessible(true);
        $result = $property->getValue($sut);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data Provider for test_humanify.
     *
     * @return array An array of data to use for testing.
     */
    public function provideHumanify()
    {
        return [
            'dash and underscore test' => [
                'expected' => 'the value',
                'input'    => '-the_value',
                'array'    => [
                    '-' => ' ',
                    '_' => ' '
                ],
            ],
        ];
    }

    /**
     * Tests PhpString\Utils::machinify
     */
    public function test_machinify()
    {
        $sut = $this->getMockBuilder('\PhpString\Utils')
            ->disableOriginalConstructor()
            ->setMethods(['dashify', 'lowercasify'])
            ->getMock();

        $sut->expects($this->once())->method('dashify')->will($this->returnValue($sut));
        $sut->expects($this->once())->method('lowercasify')->will($this->returnValue($sut));

        $result = $sut->machinify();
        // $this->assertEquals($sut, $result);
    }

    /**
     * Tests PhpString\Utils::dashify
     *
     * @dataProvider provideDashify
     */
    public function testDashify($expected, $input, $replacements)
    {
        $sut = $this->getMockBuilder('\PhpString\Utils')
            ->setConstructorArgs([$input])
            ->setMethods(['buildAssociativeArrayOfSeparators'])
            ->getMock();

        $sut->expects($this->once())
            ->method('buildAssociativeArrayOfSeparators')
            ->with($this->equalTo('-'))
            ->will($this->returnValue($replacements));

        $result = $sut->dashify();
        // $this->assertSame($sut, $result);

        $property = new \ReflectionProperty('\PhpString\Utils', 'string');
        $property->setAccessible(true);
        $result = $property->getValue($sut);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data Provider for testDashify.
     *
     * @return array An array of data to use for testing.
     */
    public function provideDashify()
    {
        return [
            [
                'expected' => 'the-value',
                'input'    => 'the value',
                'array'    => [
                    ' ' => '-',
                    '_' => '-'
                ],
            ]
        ];
    }

    /**
     * Tests PhpString\Utils::underscorify
     *
     * @dataProvider provideUnderscorify
     */
    public function testUnderscorify($expected, $input, $replacements)
    {
        $sut = $this->getMockBuilder('\PhpString\Utils')
            ->setConstructorArgs([$input])
            ->setMethods(['buildAssociativeArrayOfSeparators'])
            ->getMock();

        $sut->expects($this->once())
            ->method('buildAssociativeArrayOfSeparators')
            ->with($this->equalTo('_'))
            ->will($this->returnValue($replacements));

        $result = $sut->underscorify();
        // $this->assertSame($sut, $result);

        $property = new \ReflectionProperty('\PhpString\Utils', 'string');
        $property->setAccessible(true);
        $result = $property->getValue($sut);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data Provider for testUnderscorify.
     *
     * @return array An array of data to use for testing.
     */
    public function provideUnderscorify()
    {
        return [
            [
                'expected' => 'the_value',
                'input'    => 'the value',
                'array'    => [
                    ' ' => '_',
                    '-' => '_'
                ],
            ]
        ];
    }

    /**
     * Tests PhpString\Utils::lowercasify
     *
     * @dataProvider provideLowercasify
     */
    public function testLowercasify($expected, $string)
    {
        $sut = new Utils($string);
        $sut->lowercasify();

        $property = new \ReflectionProperty('\PhpString\Utils', 'string');
        $property->setAccessible(true);
        $result = $property->getValue($sut);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data Provider for testLowercasify.
     *
     * @return array An array of data to use for testing.
     */
    public function provideLowercasify()
    {
        return [
            [
                'expected' => 'expected value',
                'string'   => 'eXpectED VALUE',
            ],
            [
                'expected' => 'expected valu !',
                'string'   => 'eXpectED VALU !',
            ],
            [
                'expected' => 'expected value ',
                'string'   => 'eXpectED VALUE ',
            ],
        ];
    }

    /**
     * Tests PhpString\Utils::uppercasify
     *
     * @dataProvider provideUppercasify
     */
    public function testUppercasify($expected, $string)
    {
        $sut = new Utils($string);
        $sut->uppercasify();

        $property = new \ReflectionProperty('\PhpString\Utils', 'string');
        $property->setAccessible(true);
        $result = $property->getValue($sut);

        $this->assertEquals($expected, $result);
    }

    /**
     * Data Provider for testUppercasify.
     *
     * @return array An array of data to use for testing.
     */
    public function provideUppercasify()
    {
        return [
            [
                'expected' => 'EXPECTED VALUE',
                'string'   => 'eXpectED VALUE',
            ],
            [
                'expected' => 'EXPECTED VALU !',
                'string'   => 'eXpectED VALU !',
            ],
            [
                'expected' => 'EXPECTED VALUE ',
                'string'   => 'eXpectED VALUE ',
            ],
        ];
    }

    /**
     * Tests PhpString\Utils::buildAssociativeArrayOfSeparators
     *
     * @dataProvider provide_buildAssociativeArrayOfSeparators
     */
    public function test_buildAssociativeArrayOfSeparators($expected, $value, $separators)
    {
        $sut = new Utils('test', $separators);

        $method = new \ReflectionMethod('\PhpString\Utils', 'buildAssociativeArrayOfSeparators');
        $method->setAccessible(true);

        $result = $method->invoke($sut, $value);
        $this->assertEquals($expected, $result);
    }

    /**
     * Data Provider for test_buildAssociativeArrayOfSeparators.
     *
     * @return array An array of data to use for testing.
     */
    public function provide_buildAssociativeArrayOfSeparators()
    {
        return [
            [
                'expected'   => ['-' => ' '],
                'value'      => ' ',
                'separators' => ['-']
            ]
        ];
    }

    /**
     * Tests PhpString\Utils::getString
     */
    public function testGetString()
    {
        $expected = 'expected value';
        $sut      = new Utils($expected);
        $result   = $sut->getString();
        $this->assertEquals($expected, $result);
    }
}