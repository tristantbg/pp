<?php if(!defined('KIRBY')) exit ?>

title: Section
files: false
pages: false
fields:
  prevnext: prevnext
  title:
    label: Title
    type:  text
  sections:
    label: Sections
    type: structure
    style: table
    fields:
      itemtext:
        label: Text
        type: textarea
      itemdate:
        label: Date
        type: date
        format: YYYY