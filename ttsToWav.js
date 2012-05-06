//TTS-TO-WAV (English or Spanish conversion Version 1.0)
//
var i = 0;
var x = 0;
var y = myField.length;
var SpanishPrefix = 'audio/sp_';
var EnglishPrefix = 'audio/';
var fileSuffix = '.wav';
var arrayEnglishField = new Array(y);
var arraySpanishField = new Array(y);
for (i=1;i<=y;i++)
{
 x = i - 1;
arrayEnglishField[i] = EnglishPrefix + myField.substring(x,i) + fileSuffix;
arraySpanishField[i] = SpanishPrefix + myField.substring(x,i) + fileSuffix;
}