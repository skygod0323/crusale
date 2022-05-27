/*
 * NoGray Calendar Component
 *
 * Copyright (c), All right reserved
 * Gazing Design - http://www.NoGray.com
 * http://www.nogray.com/license.php
 */
 
ng.Language.load("calendar");ng.Assets.load_style(ng_config.assests_dir+"components/calendar/css/"+ng_config.css_skin_prefix+"cal_style.css");ng.Calendar=function(b){this.privates={date_format:"D, d M Y",server_date_format:"Y-n-j",num_months:1,num_col:3,css_prefix:"ng_cal_",start_day:0,start_date:"today",end_date:"year+10",year_select:null,month_select:null,date_select:null,allow_selection:true,multi_selection:false,max_selection:0,language:ng_config.language,formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),selected_date_formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),out_of_range_formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),other_month_formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),dates_off:null,allow_dates_off_selection:false,dates_off_formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),days_off:null,allow_days_off_selection:false,days_off_formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),weekend:null,allow_weekend_selection:false,weekend_formatter:function(c){return ng.Language.translate_numbers(c.getDate(),this.get_language())}.bind(this),force_selections:null,date_on_avaliable:null,days_text:"mid",months_text:"long",right_arrow_img:ng_config.assests_dir+"components/calendar/images/right_arrow.gif",right_arrow_img_disabled:ng_config.assests_dir+"components/calendar/images/right_arrow_dis.gif",left_arrow_img:ng_config.assests_dir+"components/calendar/images/left_arrow.gif",left_arrow_img_disabled:ng_config.assests_dir+"components/calendar/images/left_arrow_dis.gif",calendar_img:ng_config.assests_dir+"components/calendar/images/calendar.gif",calendar_img_disabled:ng_config.assests_dir+"components/calendar/images/calendar_dis.gif",header_format:"F Y",close_on_select:null,selected_date:null,display_date:null,buttons_color:ng_config.button_color,buttons_over_color:ng_config.button_over_color,buttons_down_color:null,buttons_disable_color:null,buttons_gloss:ng_config.button_gloss,hide_clear_button:false,hide_view_all_dates_button:false,was_cal_made:false};if(!ng.defined(b)){b={}}if(ng.defined(b.events)){this.add_events(b.events);delete b.events}ng.obj_merge(this.privates,b);if(!ng.defined(this.privates.close_on_select)){if(this.privates.multi_selection){this.privates.close_on_select=false}else{this.privates.close_on_select=true}}this.make_id("calendar");this.privates.start_date=this.process_date(this.privates.start_date,new Date());this.privates.end_date=this.process_date(this.privates.end_date);if(!ng.defined(this.privates.date_on_avaliable)){this.privates.date_on_avaliable={}}var a=this.privates.selected_date;this.privates.selected_date=[];if(ng.defined(a)){this.select_date(a,true)}if(!ng.defined(this.privates.display_date)){if(this.privates.selected_date.length>0){this.privates.display_date=this.privates.selected_date[0].clone()}else{this.privates.display_date=this.privates.start_date.clone()}}else{this.privates.display_date=this.process_date(this.privates.display_date,new Date())}if((ng.defined(this.privates.input))||(ng.defined(this.privates.object))){this.make()}};ng.Calendar.inherit(ng.Component);ng.extend_proto(ng.Calendar,{has_type:"calendar",make:function(a){if(this.privates.was_cal_made){return this}this.privates.was_cal_made=true;if(!ng.defined(a)){if(ng.defined(this.privates.input)){var a=this.privates.input}else{var a=this.privates.object}}if(ng.type(a)=="object"){this.privates.year_select=ng.get(a.year);this.privates.month_select=ng.get(a.month);this.privates.date_select=ng.get(a.date)}else{var e=ng.get(a);if((e.get("tag")=="input")||(e.get("tag")=="textarea")){this.privates.input_field=e}else{this.set_object(e)}}var d=((ng.defined(this.privates.input_field))||(ng.defined(this.privates.year_select)));if(d){var c="<table cellspacing='0' cellpadding='0' class='ng_input_button_table' id='input_button_table"+this.id+"' dir='"+ng.Language.get_dir(this.get_language())+"'>";c+="<tr><td id='input_holder_td"+this.id+"'></td><td id='button_holder_td"+this.id+"'></td></tr>";c+="</table>";ng.dump_div.innerHTML=c;this.privates.input_table_holder=ng.get("input_button_table"+this.id);this.set_input(ng.create("input",{"class":this.privates.css_prefix+"input_field",id:"input_field"+this.id,events:{change:function(){if(this.get_input().value!=""){var j="";var f=this.get_input().value;if(this.get_date_format().indexOf("\\")!=-1){j="\\"}else{if(this.get_date_format().indexOf("-")!=-1){j="-"}else{if(this.get_date_format().indexOf("/")!=-1){j="/"}}}if(j!=""){var g=this.get_date_format().split(j);if(g.length>=3){if((g[0]=="j")||(g[0]=="d")){var i=f.split(j);f=i[1]+"-"+i[0]+"-"+i[2]}}}var h=this.process_date(f);if(h.getTime()<this.get_start_date().getTime()){h=this.get_start_date().clone();this.fire_event("inputPreStartDate")}if(h.getTime()>this.get_end_date().getTime()){h=this.get_end_date().clone();this.fire_event("inputPostEndDate")}this.update_calendar(h);this.select_date(h)}}.bind(this)}}));ng.get("input_holder_td"+this.id).append_element(this.get_input());if(ng.defined(this.privates.input_field)){this.privates.input_field=ng.get(this.privates.input_field);this.privates.input_field.append_element(this.privates.input_table_holder,"before");this.privates.input_field.value="";this.privates.input_field.set_style("display","none")}if(ng.defined(this.privates.year_select)){this.privates.year_select=ng.get(this.privates.year_select);this.privates.month_select=ng.get(this.privates.month_select);this.privates.date_select=ng.get(this.privates.date_select);this.privates.year_select.append_element(this.privates.input_table_holder,"before");this.privates.year_input=ng.create("input",{name:this.privates.year_select.name,id:this.privates.year_select.id,styles:{display:"none"}});this.privates.month_input=ng.create("input",{name:this.privates.month_select.name,id:this.privates.month_select.id,styles:{display:"none"}});this.privates.date_input=ng.create("input",{name:this.privates.date_select.name,id:this.privates.date_select.id,styles:{display:"none"}});this.privates.year_select.replace(this.privates.year_input);this.privates.month_select.replace(this.privates.month_input);this.privates.date_select.replace(this.privates.date_input)}this.privates.calendar_button=new ng.Button({icon:this.privates.calendar_img,stop_default:true,hide_component:true,color:this.privates.buttons_color,over_color:this.privates.buttons_over_color,down_color:this.privates.buttons_down_color,disable_color:this.privates.buttons_disable_color,gloss:this.privates.buttons_gloss,events:{disable:function(){this.privates.calendar_button.set_icon(this.privates.calendar_img_disabled)}.bind(this),enable:function(){this.privates.calendar_button.set_icon(this.privates.calendar_img)}.bind(this)}});this.privates.calendar_button.make("button_holder_td"+this.id);this.set_button(this.privates.calendar_button)}var b=this.get_last_selected_date();if((ng.defined(b))&&(b!="")){this.update_field_value(b,true)}this.set();return this.create_calendar_frame()},process_date:function(c,b){var a;if(!ng.defined(b)){var b=this.privates.start_date.clone()}b=b.clone();if(ng.type(c)=="date"){a=c}else{if(ng.type(c)=="object"){a=b.from_object(c)}else{if(ng.type(c)=="string"){a=b.from_string(c)}else{if(ng.type(c)=="number"){a=new Date(c)}else{return null}}}}return this.set_time(a)},set_time:function(a){a.setHours(11);a.setSeconds(0);a.setMinutes(0);a.setMilliseconds(0);return a},is_selectable:function(b){if(!this.privates.allow_selection){return[false,"selection not allowed"]}b=this.process_date(b);var a=[true,b];if(this.is_out_of_range(b)){a=[false,"out of range"]}else{if(this.is_date_off(b)){a=[this.privates.allow_dates_off_selection,"date off"]}else{if(this.is_day_off(b)){a=[this.privates.allow_days_off_selection,"day off"]}else{if(this.is_weekend(b)){a=[this.privates.allow_weekend_selection,"weekend"]}}}}if(!a[0]){if(this.is_forced_selection(b)){a[0]=true}}return a},is_out_of_range:function(a){a=this.process_date(a);if(a.getTime()<this.privates.start_date.getTime()){return true}if(a.getTime()>this.privates.end_date.getTime()){return true}return false},check_dates_off:function(c,a){c=this.process_date(c);var b=false;a.each(function(d){d=this.process_date(d,c);if(c.getTime()==d.getTime()){b=true;return false}}.bind(this));return b},is_date_off:function(a){if(!ng.defined(this.privates.dates_off)){return false}return this.check_dates_off(a,this.privates.dates_off)},is_forced_selection:function(a){if(!ng.defined(this.privates.force_selections)){return false}return this.check_dates_off(a,this.privates.force_selections)},check_days_off:function(c,a){c=this.process_date(c);var b=false;a.each(function(d){if(d==c.getDay()){b=true;return false}}.bind(this));return b},is_day_off:function(a){if(!ng.defined(this.privates.days_off)){return false}return this.check_days_off(a,this.privates.days_off)},is_weekend:function(a){if(!ng.defined(this.privates.weekend)){return false}return this.check_days_off(a,this.privates.weekend)},is_selected:function(a){if(!this.get_allow_selection()){return false}return this.check_dates_off(a,this.privates.selected_date)},select_dates:function(a){return this.select_date(a)},select_date:function(b,a){if(!this.get_allow_selection()){return}if(!ng.defined(b)){return}if(ng.type(b)!="array"){b=[b]}if(b.length==0){return}b=b.unique();b.each(function(c){c=this.process_date(c);if((this.is_selectable(c)[0])&&(!this.is_selected(c))){this.push_select_date(c);if(ng.defined(ng.get("date_"+this.id+"_"+(c.getMonth()+1)+"_"+c.getDate()+"_"+c.getFullYear()))){ng.get("date_"+this.id+"_"+(c.getMonth()+1)+"_"+c.getDate()+"_"+c.getFullYear()).add_class(this.privates.css_prefix+"selected_date")}this.create_multi_select_dates_list();if(!ng.defined(a)){this.fire_event("select",[c])}}if(this.is_selectable(c)[0]){this.update_field_value(c,true)}}.bind(this));if(this.get_close_on_select()){(function(){this.close()}.delay(100,this))}return this},create_multi_select_dates_list:function(){if(!ng.defined(this.privates.clear_button)){return}if(this.privates.multi_selection){if(this.privates.selected_date.length>0){if(!this.privates.hide_clear_button){this.privates.clear_button.enable()}if(!this.privates.hide_view_all_dates_button){this.privates.show_sel_dts_button.enable()}}else{if(!this.privates.hide_clear_button){this.privates.clear_button.disable()}if(!this.privates.hide_view_all_dates_button){this.privates.show_sel_dts_button.disable();this.privates.show_sel_dts_button.set_text(ng.Language.t("view_selected_dates",this.get_language()));ng.get("all_sel_dts_tr"+this.id).set_style("display","none")}}}if((this.privates.multi_selection)&&(ng.get("all_sel_dts_tr"+this.id).get_style("display")!="none")){var b=[];var a=0;b.push("<table class='"+this.privates.css_prefix+"date_list_table'>");var c=Math.min(this.get_num_col(),this.get_num_months());this.privates.selected_date.each(function(d){if(a%c==0){b.push("<tr>")}b.push("<td class='"+this.privates.css_prefix+"date_list_td' rel='goto-");b.push((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear());b.push("'>"+d.print(this.get_date_format(),this.get_language())+"</td>");b.push("<td class='"+this.privates.css_prefix+"date_list_remove_td' rel='remove-");b.push((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear());b.push("'></td>");a++;if(a%c==0){b.push("</tr>")}}.bind(this));b.push("</table>");ng.get("all_dates_td"+this.id).set_html(b)}},push_select_date:function(b){if(this.privates.multi_selection){this.privates.selected_date=[b].concat(this.privates.selected_date);if((this.privates.max_selection>0)&&(this.privates.selected_date.length>this.privates.max_selection)){for(var a=this.privates.max_selection;a<this.privates.selected_date.length;a++){this.unselect_date(this.privates.selected_date[a])}this.privates.selected_date=this.privates.selected_date.slice(0,this.privates.max_selection)}}else{this.unselect_date(this.privates.selected_date);this.privates.selected_date=[b]}},get_selected_dates:function(){return this.get_selected_date()},get_selected_date:function(){if(this.privates.selected_date.length==1){return this.get_last_selected_date()}else{return this.privates.selected_date}},get_last_selected_date:function(){if(this.privates.selected_date.length>0){return this.privates.selected_date[0]}else{return null}},get_first_selected_date:function(){if(this.privates.selected_date.length>0){return this.privates.selected_date[this.privates.selected_date.length-1]}else{return null}},unselect_dates:function(a){return this.unselect_date(a)},unselect_date:function(a){if(!this.get_allow_selection()){return}if(!ng.defined(a)){return}if(ng.type(a)=="array"){if(a.length==0){return}a.each(function(b){b=this.process_date(b);this.privates.selected_date.remove_value(b,function(c){return c.getTime()});if(ng.defined(ng.get("date_"+this.id+"_"+(b.getMonth()+1)+"_"+b.getDate()+"_"+b.getFullYear()))){ng.get("date_"+this.id+"_"+(b.getMonth()+1)+"_"+b.getDate()+"_"+b.getFullYear()).remove_class(this.privates.css_prefix+"selected_date")}this.update_field_value(b,false);this.create_multi_select_dates_list();this.fire_event("unselect",[b])}.bind(this))}else{var a=this.process_date(a);this.privates.selected_date.remove_value(a,function(b){return b.getTime()});if(ng.defined(ng.get("date_"+this.id+"_"+(a.getMonth()+1)+"_"+a.getDate()+"_"+a.getFullYear()))){ng.get("date_"+this.id+"_"+(a.getMonth()+1)+"_"+a.getDate()+"_"+a.getFullYear()).remove_class(this.privates.css_prefix+"selected_date")}this.update_field_value(a,false);this.create_multi_select_dates_list();this.fire_event("unselect",[a])}},clear_selection:function(){this.privates.selected_date.empty();if(ng.defined(this.privates.year_input)){this.privates.year_input.value=this.privates.month_input.value=this.privates.date_input.value=""}if(ng.defined(this.privates.input_field)){this.privates.input_field.value=""}if(ng.defined(this.get_input())){this.get_input().value=""}this.create_calendar();this.create_multi_select_dates_list();this.fire_event("clear");return this},update_field_value:function(a,b){if(b){if(ng.defined(this.privates.year_input)){this.privates.year_input.value=a.getFullYear();this.privates.month_input.value=a.getMonth()+1;this.privates.date_input.value=a.getDate()}if((ng.defined(this.privates.input_field))&&(this.privates.input_field.value.indexOf(a.print(this.get_server_date_format(),this.get_language()))==-1)){if(this.privates.input_field.value!=""){this.privates.input_field.value+=","}this.privates.input_field.value+=a.print(this.get_server_date_format(),this.get_language())}if(ng.defined(this.get_input())){this.get_input().value=a.print(this.get_date_format(),this.get_language())}}else{if(ng.defined(this.privates.year_input)){if((this.privates.year_input.value==a.getFullYear())&&(this.privates.month_input.value==a.getMonth()+1)&&(this.privates.date_input.value=a.getDate())){this.privates.year_input.value=this.privates.month_input.value=this.privates.date_input.value=""}}if(ng.defined(this.privates.input_field)){this.privates.input_field.value=this.privates.input_field.value.replace(","+a.print(this.get_server_date_format(),this.get_language()),"");this.privates.input_field.value=this.privates.input_field.value.replace(a.print(this.get_server_date_format(),this.get_language()),"");if(this.privates.input_field.value.substr(0,1)==","){this.privates.input_field.value=this.privates.input_field.value.substr(1)}}if(ng.defined(this.get_input())){if(this.privates.selected_date.length>0){this.get_input().value=this.get_last_selected_date().print(this.get_date_format(),this.get_language())}else{this.get_input().value=""}}}},get_date_format:function(){return this.privates.date_format},set_date_format:function(a){this.privates.date_format=a;return this},get_server_date_format:function(){return this.privates.server_date_format},set_server_date_format:function(a){this.privates.server_date_format=a;return this},set_language:function(a){this.privates.language=a;return this},get_language:function(){return this.privates.language},get_num_months:function(){return this.privates.num_months},set_num_months:function(a,b){this.privates.num_months=a;return this.create_calendar(b)},get_num_col:function(){return this.privates.num_col},set_num_col:function(a,b){this.privates.num_col=a;return this.create_calendar(b)},get_start_day:function(){return this.privates.start_day},set_start_day:function(b,a){this.privates.start_day=b;return this.create_calendar(a)},get_start_date:function(){return this.privates.start_date},set_start_date:function(a,b){this.privates.start_date=this.process_date(a,new Date());return this.update_year_select(b)},get_display_date:function(){return this.privates.display_date},set_display_date:function(a,b){this.privates.display_date=this.process_date(a);return this.create_calendar(b)},get_end_date:function(){return this.privates.end_date},set_end_date:function(a,b){this.privates.end_date=this.process_date(a);return this.update_year_select(b)},update_year_select:function(c){var e=ng.get("yr_sel_menu"+this.id);if(!ng.defined(e)){return this}e.set_html("");var d=this.get_display_date().getFullYear();var b;for(var a=this.get_start_date().getFullYear();a<=this.get_end_date().getFullYear();a++){b=document.createElement("option");b.value=a;b.innerHTML=ng.Language.translate_numbers(a,this.get_language());if(a==d){b.selected="selected"}e.appendChild(b)}if(c){return this.create_calendar(c)}return this.update_calendar(this.get_display_date(),true)},get_date_on_avaliable:function(){return this.privates.date_on_avaliable},set_date_on_avaliable:function(a){this.privates.date_on_avaliable=a;return this},get_allow_selection:function(){return this.privates.allow_selection},set_allow_selection:function(a){this.privates.allow_selection=a;return this},get_multi_selection:function(){return this.privates.multi_selection},set_multi_selection:function(b){this.privates.multi_selection=b;if((!b)&&(this.privates.selected_date.length>1)){var a=this.get_last_selected_date();if(ng.defined(a)){this.clear_selection();this.select_date(a)}}return this},get_max_selection:function(){return this.privates.max_selection},set_max_selection:function(c){this.privates.max_selection=c;if(this.privates.selected_date.length>c){var b=[];for(var a=c;a<this.privates.selected_date.length;a++){b.push(this.privates.selected_date)}this.unselect_date(b)}return this},get_dates_off:function(){return this.privates.dates_off},set_dates_off:function(a,b){this.privates.dates_off=a;return this.create_calendar(b)},get_allow_dates_off_selection:function(){return this.privates.allow_dates_off_selection},set_allow_dates_off_selection:function(a,b){this.privates.allow_dates_off_selection=a;return this.create_calendar(b)},set_dates_off_formatter:function(b,a){this.privates.dates_off_formatter=b;return this.create_calendar(a)},get_days_off:function(){return this.privates.days_off},set_days_off:function(a,b){this.privates.days_off=a;return this.create_calendar(b)},get_allow_days_off_selection:function(){return this.privates.allow_days_off_selection},set_allow_days_off_selection:function(a,b){this.privates.allow_days_off_selection=a;return this.create_calendar(b)},set_days_off_formatter:function(b,a){this.privates.days_off_formatter=b;return this.create_calendar(a)},get_weekend:function(){return this.privates.weekend},set_weekend:function(a,b){this.privates.weekend=a;return this.create_calendar(b)},get_allow_weekend_selection:function(){return this.privates.allow_weekend_selection},set_allow_weekend_selection:function(a,b){this.privates.allow_weekend_selection=a;return this.create_calendar(b)},set_weekend_formatter:function(b,a){this.privates.weekend_formatter=b;return this.create_calendar(a)},get_force_selections:function(){return this.privates.force_selections},set_force_selections:function(a,b){this.privates.force_selections=a;return this.create_calendar(b)},get_days_text:function(){return this.privates.days_text},set_days_text:function(a,b){this.privates.days_text=a;return this.create_calendar(b)},get_months_text:function(){return this.privates.months_text},set_months_text:function(a,b){this.privates.months_text=a;return this.create_calendar(b)},get_previou_td_html:function(){return this.privates.previou_td_html},set_previou_td_html:function(a,b){this.privates.previou_td_html=a;return this.create_calendar(b)},get_previou_td_html_disabled:function(){return this.privates.previou_td_html_disabled},set_previou_td_html_disabled:function(a,b){this.privates.previou_td_html_disabled=a;return this.create_calendar(b)},get_next_month_html:function(){return this.privates.next_month_html},set_next_month_html:function(a,b){this.privates.next_month_html=a;return this.create_calendar(b)},get_next_month_html_disabled:function(){return this.privates.next_month_html_disabled},set_next_month_html_disabled:function(a,b){this.privates.next_month_html_disabled=a;return this.create_calendar(b)},get_header_format:function(){return this.privates.header_format},set_header_format:function(a,b){this.privates.header_format=a;return this.create_calendar(b)},get_close_on_select:function(){return this.privates.close_on_select},set_close_on_select:function(a){this.privates.close_on_select=a;return this},create_calendar_frame:function(){var d=[];this.privates.main_events=new ng.InnerHtmlEvents({click:function(i){var g=i.src_element.get("rel");if(!ng.defined(g)){return this}if(g!=""){if(g.indexOf("out_of_range")!=-1){return}if(g.indexOf("other_month")!=-1){var h=this.process_date(g.replace("other_month",""))}else{var h=this.process_date(g)}if(ng.defined(h)){if(!this.is_month_visible(h)){this.update_calendar(h)}if(this.is_selected(h)){this.unselect_date(h)}else{this.select_date(h)}this.fire_event("dateclick",[h],i)}}}.bind(this)});this.privates.mn_sel_events=new ng.InnerHtmlEvents({change:function(){var g=this.get_display_date().clone();g.setMonth(ng.get("mn_sel_menu"+this.id).value);this.update_calendar(g)}.bind(this)});this.privates.yr_sel_events=new ng.InnerHtmlEvents({change:function(){var g=this.get_display_date().clone();g.setYear(ng.get("yr_sel_menu"+this.id).value);this.update_calendar(g)}.bind(this)});d.push("<table class='"+this.privates.css_prefix+"cal_frame_table' id='cal_frame_table"+this.id+"' dir='"+ng.Language.get_dir(this.get_language())+"'>");d.push("<tr id='calendar_buttons"+this.id+"' style='display:none;'>");var f="left";var e="right";if(ng.Language.get_dir(this.get_language())=="rtl"){f="right";e="left"}d.push("<td id='pre_month"+this.id+"' class='"+this.privates.css_prefix+f+"_month_td'></td>");d.push("<td id='year_td"+this.id+"' class='"+this.privates.css_prefix+"year_td'></td>");d.push("<td id='nex_month"+this.id+"' class='"+this.privates.css_prefix+e+"_month_td'></td>");d.push("</tr>");d.push("<tr id='years_sel_tr"+this.id+"' style='display:none;'><td colspan='3' class='"+this.privates.css_prefix+"years_select_td'>");d.push("<select id='mn_sel_menu"+this.id+"' "+this.privates.mn_sel_events.get_html()+">");var b=ng.Language.t("date",this.get_language());for(var c=0;c<12;c++){d.push("<option value='"+c+"'>"+b.months[this.get_months_text()][c]+"</option>")}d.push("</select> <select id='yr_sel_menu"+this.id+"' "+this.privates.yr_sel_events.get_html()+">");d.push("</select></td></tr>");d.push("<tr><td id='cal_td"+this.id+"' class='"+this.privates.css_prefix+"cal_td' colspan='3' ");d.push(this.privates.main_events.get_html()+"></td></tr>");if(this.get_multi_selection()){this.privates.multi_dates_events=new ng.InnerHtmlEvents({click:function(i){var h=i.src_element.get("rel");if(!ng.defined(h)){return this}if(h!=""){var g=h.split("-");if(g[0]=="remove"){this.unselect_date(g[1])}else{this.update_calendar(g[1])}}}.bind(this)});d.push("<tr><td colspan='3' id='clear_all_td"+this.id+"' class='"+this.privates.css_prefix+"bottom_bar'></td></tr>");d.push("<tr id='all_sel_dts_tr"+this.id+"' style='display:none;'>");d.push("<td colspan='3' class='"+this.privates.css_prefix+"all_selected_dates' ");d.push(this.privates.multi_dates_events.get_html()+" id='all_dates_td"+this.id+"'></td></tr>")}d.push("</table>");this.set_html(d);this.privates.content_td=ng.get("cal_td"+this.id);this.update_year_select(true);var a=this.privates.right_arrow_img;if(ng.Language.get_dir(this.get_language())=="rtl"){a=this.privates.left_arrow_img}this.privates.pre_button=new ng.Button({icon:this.privates.right_arrow_img,stop_default:true,color:this.privates.buttons_color,over_color:this.privates.buttons_over_color,down_color:this.privates.buttons_down_color,disable_color:this.privates.buttons_disable_color,gloss:this.privates.buttons_gloss,events:{disable:function(){if(ng.Language.get_dir(this.get_language())=="rtl"){this.privates.pre_button.set_icon(this.privates.left_arrow_img_disabled)}else{this.privates.pre_button.set_icon(this.privates.right_arrow_img_disabled)}}.bind(this),enable:function(){if(ng.Language.get_dir(this.get_language())=="rtl"){this.privates.pre_button.set_icon(this.privates.left_arrow_img)}else{this.privates.pre_button.set_icon(this.privates.right_arrow_img)}}.bind(this),click:function(){var g=new Date(this.get_display_date().getFullYear(),this.get_display_date().getMonth(),1);g.setMonth(g.getMonth()-this.get_num_months());this.update_calendar(g);this.fire_event("premonthclick")}.bind(this)}});this.privates.pre_button.make("pre_month"+this.id);this.privates.year_button=new ng.Button({text:"",stop_default:true,width:"100%",color:this.privates.buttons_color,over_color:this.privates.buttons_over_color,down_color:this.privates.buttons_down_color,disable_color:this.privates.buttons_disable_color,gloss:this.privates.buttons_gloss,events:{click:function(){if(ng.get("years_sel_tr"+this.id).get_style("display")=="none"){ng.get("years_sel_tr"+this.id).set_style("display","");this.fire_event("showyear")}else{ng.get("years_sel_tr"+this.id).set_style("display","none");this.fire_event("hideyear")}this.fire_event("yearclick")}.bind(this)}});this.privates.year_button.make("year_td"+this.id);var a=this.privates.left_arrow_img;if(ng.Language.get_dir(this.get_language())=="rtl"){a=this.privates.right_arrow_img}this.privates.nex_button=new ng.Button({icon:a,stop_default:true,color:this.privates.buttons_color,over_color:this.privates.buttons_over_color,down_color:this.privates.buttons_down_color,disable_color:this.privates.buttons_disable_color,gloss:this.privates.buttons_gloss,events:{disable:function(){if(ng.Language.get_dir(this.get_language())=="rtl"){this.privates.nex_button.set_icon(this.privates.right_arrow_img_disabled)}else{this.privates.nex_button.set_icon(this.privates.left_arrow_img_disabled)}}.bind(this),enable:function(){if(ng.Language.get_dir(this.get_language())=="rtl"){this.privates.nex_button.set_icon(this.privates.right_arrow_img)}else{this.privates.nex_button.set_icon(this.privates.left_arrow_img)}}.bind(this),click:function(){var g=new Date(this.get_display_date().getFullYear(),this.get_display_date().getMonth(),1);g.setMonth(g.getMonth()+this.get_num_months());this.update_calendar(g);this.fire_event("nextmonthclick")}.bind(this)}});this.privates.nex_button.make("nex_month"+this.id);if(this.get_multi_selection()){if(!this.privates.hide_clear_button){this.privates.clear_button=new ng.Button({text:ng.Language.t("clear",this.get_language()),stop_default:true,color:this.privates.buttons_color,over_color:this.privates.buttons_over_color,down_color:this.privates.buttons_down_color,disable_color:this.privates.buttons_disable_color,gloss:this.privates.buttons_gloss,enabled:false,events:{click:function(){this.clear_selection()}.bind(this)}});this.privates.clear_button.make("clear_all_td"+this.id)}if(!this.privates.hide_view_all_dates_button){this.privates.show_sel_dts_button=new ng.Button({text:ng.Language.t("view_selected_dates",this.get_language()),stop_default:true,color:this.privates.buttons_color,over_color:this.privates.buttons_over_color,down_color:this.privates.buttons_down_color,disable_color:this.privates.buttons_disable_color,gloss:this.privates.buttons_gloss,enabled:false,events:{click:function(){if(ng.get("all_sel_dts_tr"+this.id).get_style("display")=="none"){ng.get("all_sel_dts_tr"+this.id).set_style("display","");this.privates.show_sel_dts_button.set_text(ng.Language.t("hide_selected_dates",this.get_language()));this.create_multi_select_dates_list()}else{ng.get("all_sel_dts_tr"+this.id).set_style("display","none");this.privates.show_sel_dts_button.set_text(ng.Language.t("view_selected_dates",this.get_language()))}}.bind(this)}});this.privates.show_sel_dts_button.make("clear_all_td"+this.id)}}this.update_calendar(this.get_display_date(),true);ng.get("calendar_buttons"+this.id).style.display="";this.fire_event("load");return this},is_month_visible:function(c){c=this.process_date(c);var b=0;var a=this.get_display_date().clone();while(b<this.get_num_months()){if((c.getMonth()==a.getMonth())&&(c.getFullYear()==a.getFullYear())){return true}a.setMonth(a.getMonth()+1);b++}return false},update_calendar:function(b,a){b=this.process_date(b);if((!ng.defined(a))&&(this.is_month_visible(b))){return this}if(b.getTime()<this.get_start_date().getTime()){b=this.get_start_date().clone()}if(b.getTime()>this.get_end_date().getTime()){b=this.get_end_date().clone()}var d=b.clone();d.setMonth(b.getMonth()-1);if((d.getFullYear()<this.get_start_date().getFullYear())||((d.getFullYear()==this.get_start_date().getFullYear())&&(d.getMonth()<this.get_start_date().getMonth()))){this.privates.pre_button.disable()}else{this.privates.pre_button.enable()}var c=b.clone();c.setMonth(b.getMonth()+1);if((c.getFullYear()>this.get_end_date().getFullYear())||((c.getFullYear()==this.get_end_date().getFullYear())&&(c.getMonth()>this.get_end_date().getMonth()))){this.privates.nex_button.disable()}else{this.privates.nex_button.enable()}this.set_display_date(b.clone());ng.get("yr_sel_menu"+this.id).selectedIndex=this.get_display_date().getFullYear()-this.get_start_date().getFullYear();ng.get("mn_sel_menu"+this.id).selectedIndex=this.get_display_date().getMonth();this.update_calendar_header();this.create_calendar();this.fire_event("monthchange");return this},update_calendar_header:function(){if(this.get_num_months()>1){var a=this.get_display_date().getFullYear()}else{var a=this.get_display_date().print(this.get_header_format(),this.get_language())}this.privates.year_button.set_text("<center>"+a+"</center>")},create_calendar:function(c){if(ng.defined(c)){return this}var b=[];if(this.get_num_months()>1){b.push('<table id="months_group_table'+this.id+'" class="'+this.privates.css_prefix+'months_group_table" cellspacing="3"><tr>');var d=this.get_display_date().clone();var e=this.get_num_col();for(var a=0;a<this.get_num_months();a++){b.push('<td class="'+this.privates.css_prefix+'month_group_td">');b=b.concat(this.create_month_table(d));b.push("</td>");if(((a+1)%e==0)&&(a>0)){b.push("</tr><tr>")}if(this.is_out_of_range(d)&&!this.privates.visible){break}}b.push("</table>")}else{var d=this.get_display_date().clone();b=this.create_month_table(d)}this.privates.content_td.set_html(b);return this},create_month_table:function(d){var n=[];var f=d.getMonth()+1;var s=d.getFullYear();var p=this.privates.css_prefix;n.push('<table id="month_'+f+"_"+s+"_table"+this.id+'" class="'+p+'month_table">');if(this.get_num_months()>1){n.push('<tr><th id="header_'+f+"_"+s+"_th"+this.id+'" class="'+p+'header_th" colspan="7">');n.push(d.print(this.get_header_format(),this.get_language()));n.push("</th></tr>")}n.push("<tr>");var e=0;var q=ng.Language.t("date",this.get_language());for(var m=0;m<7;m++){e=(m+this.get_start_day())%7;n.push('<td class="'+p+'day_name_td" id="day_name_'+e+"_"+f+"_"+s+"_td"+this.id+'">');n.push(q.days[this.get_days_text()][e]);n.push("</td>")}n.push("</tr>");var l=d.getMonth();var a=d.getFullYear();d.setDate(1);d.setDate(d.getDate()-(d.getDay()-this.get_start_day()));if((d.getDate()<=7)&&(d.getDate()!=1)){d.setDate(d.getDate()-7)}var r,k,c,o,b,g;var p=this.privates.css_prefix;for(var m=0;m<7;m++){n.push('<tr class="'+p+'dates_tr">');for(var h=0;h<7;h++){r=k="";o=(d.getMonth()+1)+"_"+d.getDate()+"_"+d.getFullYear();c=this.id+"_"+o;if(d.getMonth()!=l){if(this.is_out_of_range(d)){r="out_of_range";k=this.privates.out_of_range_formatter(d)}else{r="other_month";k=this.privates.other_month_formatter(d)}n.push('<td class="'+p+"date_"+o+" "+p+r+'" ');n.push('rel="'+r+(d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()+'">'+k+"</td>")}else{b=this.is_selectable(d);if(b[1]=="out of range"){r=p+"out_of_range";k=this.privates.out_of_range_formatter(d)}else{if(b[1]=="weekend"){r=p+"weekend";k=this.privates.weekend_formatter(d)}else{if(b[1]=="day off"){r=p+"day_off";k=this.privates.days_off_formatter(d)}else{if(b[1]=="date off"){r=p+"date_off";k=this.privates.dates_off_formatter(d)}else{k=this.privates.formatter(d)}}}}if(b[0]){if(this.is_selected(d)){r+=" "+p+"selected_date";k=this.privates.selected_date_formatter(d)}r+=" "+p+"selectable"}n.push('<td class="'+p+"date_"+o+" "+r+'" id="date_'+c+'" ');n.push('rel="'+(d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()+'">'+k+"</td>");if(ng.defined(this.get_date_on_avaliable()[o])){this.get_date_on_avaliable()[o].defer(this,["date_"+c])}}d.setDate(d.getDate()+1)}n.push("</tr>");if((d.getFullYear()>a)||(d.getMonth()>l)){break}}n.push("</table>");return n},remove:function(){this.fire_event("remove");this.privates.each(function(b,a){if(ng.defined(b.remove)){this.privates[a].remove()}}.bind(this));this.privates=null;return this}});
