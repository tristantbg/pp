<?php if(!defined('KIRBY')) exit ?>

title: Project
files: true
pages: false
files:
  fields:
    videolink:
      label: Video Link
      type: text
      icon: code
      help: Youtube or Vimeo
    fullwidth:
      type: checkbox
      text: Full Width
    caption:
      label: Caption
      type: textarea
fields:
  prevnext: prevnext
  title:
    label: Title
    type:  text
    width: 2/4
  featured:
    label: Featured image
    type: image
    help: Required to display project
    width: 1/4
  date:
    label: Year
    type:  date
    format: YYYY
    required: true
    width: 1/4
  client:
    label: Client
    type:  text
    width: 2/4
  category:
    label: Category
    type: checkboxes 
    options: field
    columns: 1
    field:
      page: work
      name: categories
      separator: ,
    width: 1/4
  imageonly:
    label: Image only
    type: toggle
    text: on/off
    default: off
    width: 1/4
  medias: 
    label: Images
    type: gallery
  text:
    label: Description
    type: textarea