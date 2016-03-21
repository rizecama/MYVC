/*
 **********************************************
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************
 $Id: colorpicker.js 667 2011-01-24 21:02:32Z jeffchannell $
 */

function MM_openBrWindow(theURL, winName, features, width, height, mode, id)
{
  var pickerid = ( id ) ? '_'+id : '';
  var w = 800, h = 600;
  var leftPos, topPos;

  if (navigator.appName == "Microsoft Internet Explorer")
  {
    screenY = document.body.offsetHeight
    screenX = window.screen.availWidth
  }

  else
  { // Navigator coordinates
    screenY = screen.height;
    screenX = screen.width;
  }

  if (mode)
  {
    
    var picker = $('colorpickerbg'+pickerid);
    var cursorX = picker.getPosition().x;
    var cursorY = picker.getPosition().y;

    var spacingX = 10;
    var spacingY = 10;

    if ((cursorY + height + spacingY) > screenY)
    // make sizes a negative number to move left/up
    {
      spacingY = (-30) + (height * -1);
    // if up or to left, make 30 as padding amount
    }

    if ((cursorX + width + spacingX) > screenX)
    {
      spacingX = (-30) + (width * -1);
    // if up or to left, make 30 as padding amount
    }

    if (document.all)
    {
      leftPos = cursorX + spacingX
      topPos = cursorY + spacingY
    }

    else
    { // adjust Netscape coordinates for scrolling
      leftPos = (cursorX - pageXOffset + spacingX)
      topPos = (cursorY - pageYOffset + spacingY)
    }
  }

  else
  {
    leftvar = (screenX - width) / 2
    rightvar = (screenY - height) / 2

    if (document.all)
    {
      leftPos = leftvar
      topPos = rightvar
    }

    else
    { // adjust Netscape coordinates for scrolling
      leftPos = (leftvar - pageXOffset)
      topPos = (rightvar - pageYOffset)
    }
  }

  var win_opt = features;
  win_opt += ",width=" + width + ",height=" + height + ",top=" + topPos;
  win_opt += ",left=" + leftPos;
  w = window.open(theURL, winName, win_opt);
  w.focus();
}

