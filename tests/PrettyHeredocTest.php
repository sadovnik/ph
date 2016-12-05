<?php

namespace Sadovnik\PrettyHeredoc;

use PHPUnit;

use function Sadovnik\PrettyHeredoc\ph;
use Sadovnik\PrettyHeredoc\Exceptions\InvalidArgumentException;

class HdcTest extends PHPUnit\Framework\TestCase
{
    public function testRegularCase()
    {
        $actual = ph('
            Telemachus saw her long before any one else did.
            He was sitting moodily among the suitors thinking
            about his brave father, and how he would send
            them flying out of the house, if he were to come
            to his own again and be honoured as in days gone by.
        ');

        $expected = <<<EOF
Telemachus saw her long before any one else did.
He was sitting moodily among the suitors thinking
about his brave father, and how he would send
them flying out of the house, if he were to come
to his own again and be honoured as in days gone by.
EOF;

        $this->assertEquals($expected, $actual);
    }


    public function testParagraph()
    {
        $actual = ph('
                Telemachus saw her long before any one else did.
            He was sitting moodily among the suitors thinking
            about his brave father, and how he would send
            them flying out of the house, if he were to come
            to his own again and be honoured as in days gone by.
        ');

        $expected = <<<EOF
    Telemachus saw her long before any one else did.
He was sitting moodily among the suitors thinking
about his brave father, and how he would send
them flying out of the house, if he were to come
to his own again and be honoured as in days gone by.
EOF;

        $this->assertEquals($expected, $actual);
    }

    public function testIgnoreIdentation()
    {
        $actual = ph("
            «The worst thing in the world,» said O'Brien, «varies from individual
            to individual. It may be burial alive, or death by fire, or by drowning,
            or by impalement, or fifty other deaths. There are cases where it is
            some quite trivial thing, not even fatal.»

            He had moved a little to one side, so that Winston had a better view of
            the thing on the table. It was an oblong wire cage with a handle on top
            for carrying it by. Fixed to the front of it was something that looked
            like a fencing mask, with the concave side outwards. Although it was three
            or four metres away from him, he could see that the cage was divided
            lengthways into two compartments, and that there was some kind of creature
            in each. They were rats.
        ");

        $expected = <<<EOF
«The worst thing in the world,» said O'Brien, «varies from individual
to individual. It may be burial alive, or death by fire, or by drowning,
or by impalement, or fifty other deaths. There are cases where it is
some quite trivial thing, not even fatal.»

He had moved a little to one side, so that Winston had a better view of
the thing on the table. It was an oblong wire cage with a handle on top
for carrying it by. Fixed to the front of it was something that looked
like a fencing mask, with the concave side outwards. Although it was three
or four metres away from him, he could see that the cage was divided
lengthways into two compartments, and that there was some kind of creature
in each. They were rats.
EOF;

        $this->assertEquals($expected, $actual);
    }

    public function testEmptyString()
    {
        $this->assertSame('', ph(''));
    }


    /**
     * @dataProvider provideBlankChunks
     */
    public function testBlankChunk($input)
    {
        $input = ph($input);

        $this->assertSame('', $input);
    }

    public function provideBlankChunks()
    {
        return [
            ["\n\n\n"],
            ["\n\n    \n    \n"],
            ["\n\n\t  \n    \n"]
        ];
    }

    /**
     * @expectedException Sadovnik\PrettyHeredoc\Exceptions\InvalidArgumentException
     */
    public function testThrowsInvalidArgumentException()
    {
        ph([]);
    }
}
