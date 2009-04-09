#!/usr/bin/perl

use XML::Mini::Document;
use Data::Dumper;

print "Content-type: text/plain\r\n\r\n";

$xmlDoc = XML::Mini::Document->new();
 
$XML::Mini::AutoEscapeEntities = 0;
# $XML::Mini::NoWhiteSpaces = 1;

my $file = $ARGV[0] || './test.xml';
$xmlDoc->fromFile($file);

print $xmlDoc->toString();
my $hash = $xmlDoc->toHash();
my $options = {
				'attributes'	=> {
									'-all'	=> ['num', 'version', 'myattrib'],
									'image'	=> ['drawing', 'type', 'x', 'y'],
									'part'	=> ['models', 'update'],
									'ref'	=> 'name',
									},
			};



my $otherDoc = XML::Mini::Document->new();

$otherDoc->fromHash($hash, $options);

print $otherDoc->toString();
