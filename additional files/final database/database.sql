PGDMP         &                y           WMMS    13.3    13.3 K               0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    24682    WMMS    DATABASE     j   CREATE DATABASE "WMMS" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'English_United States.1252';
    DROP DATABASE "WMMS";
                postgres    false            �            1255    24683 a   add_meeting(character varying, timestamp without time zone, timestamp without time zone, boolean)    FUNCTION     �  CREATE FUNCTION public.add_meeting(place character varying, start_time timestamp without time zone, end_time timestamp without time zone, status boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE
	s_date timestamp = start_time;
	e_date timestamp = end_time;
	sys_date timestamp = now();
	msg character varying;

BEGIN
	IF (s_date<e_date) THEN
		IF (s_date>sys_date and e_date>sys_date) THEN
			INSERT INTO meetings VALUES(default, place, start_time, end_time, 'f');
			msg = 'Successfully inserted';
		ELSE
			msg = 'both cannot be set into the past';
		END IF;
	ELSE
	    msg = 'starting time of a meeting must be before ending time';
	END IF;
  	return msg;
END;
$$;
 �   DROP FUNCTION public.add_meeting(place character varying, start_time timestamp without time zone, end_time timestamp without time zone, status boolean);
       public          postgres    false            �            1255    24684 6   add_study_group(integer, text, text, integer, integer)    FUNCTION     _  CREATE FUNCTION public.add_study_group(meet_id integer, subject text, details text, stud_id integer, member_limit integer DEFAULT 32767) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
	study_id integer;
	old_group_id int = (select study_group_id from group_members where student_id = stud_id);
	group_exist int = (SELECT COUNT(*) FROM group_members WHERE study_group_id = old_group_id);
	is_exist int = (SELECT COUNT(*) FROM group_members WHERE group_members.student_id = stud_id);
BEGIN
	IF (member_limit >= 2) THEN
		INSERT INTO study_groups VALUES(default, meet_id, subject, details, member_limit, now(),'1');
		study_id = (SELECT study_group_id FROM study_groups ORDER BY study_group_id DESC LIMIT 1);
		IF (is_exist = 0) THEN
			INSERT INTO group_members VALUES(study_id, stud_id, now(), default);
		ELSE
			DELETE FROM group_members 
			WHERE group_members.student_id = stud_id;
			insert into group_members values(study_id, stud_id, now(), default);
				IF (group_exist = 1) THEN
				DELETE FROM study_groups  
				WHERE study_groups.study_group_id = old_group_id;
				END IF;
		END IF;
	END IF;
	
END;
$$;
 z   DROP FUNCTION public.add_study_group(meet_id integer, subject text, details text, stud_id integer, member_limit integer);
       public          postgres    false            �            1255    24685    already_joined_group(integer)    FUNCTION     �  CREATE FUNCTION public.already_joined_group(stud_id integer) RETURNS TABLE(sg_id integer, subject character varying, details character varying, meet character varying)
    LANGUAGE plpgsql
    AS $$
DECLARE
	group_id int = (SELECT study_group_id from group_members where student_id = stud_id);
BEGIN
	RETURN QUERY
	SELECT study_group_id, topic, description, meeting_place 
	FROM study_groups sg
	inner join meetings me on me.meeting_id = sg.meeting_id
	WHERE sg.study_group_id = group_id;
END;
$$;
 <   DROP FUNCTION public.already_joined_group(stud_id integer);
       public          postgres    false            �            1255    24686    change_group_status(integer)    FUNCTION     _  CREATE FUNCTION public.change_group_status(group_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
	no_of_student int;
BEGIN
	no_of_student = (SELECT COUNT(*) FROM group_members 
		WHERE group_members.study_group_id = group_id);
	
	UPDATE study_groups
	SET  status = '0'
	WHERE study_groups.group_member_limit <= no_of_student;
END;
$$;
 <   DROP FUNCTION public.change_group_status(group_id integer);
       public          postgres    false            �            1255    24687 %   change_status_overload_group(integer)    FUNCTION     q  CREATE FUNCTION public.change_status_overload_group(group_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
	no_of_student int;
	gp_limit int;
BEGIN
	no_of_student = (SELECT COUNT(*) FROM group_members 
		WHERE group_members.study_group_id = group_id);
	gp_limit = (select study_groups.group_member_limit from study_groups where study_groups.study_group_id = group_id);
	if(no_of_student >= gp_limit) then
		UPDATE study_groups
		SET  status = '0'
		where study_groups.study_group_id = group_id;
	else 
		UPDATE study_groups
		SET  status = '1'
		where study_groups.study_group_id = group_id;
	end if;
END;
$$;
 E   DROP FUNCTION public.change_status_overload_group(group_id integer);
       public          postgres    false            �            1255    24688 S   create_study_group(integer, text, text, integer, timestamp with time zone, boolean)    FUNCTION       CREATE FUNCTION public.create_study_group(meet_id integer, subject text, details text, student_limit integer, created_at timestamp with time zone, is_active boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE
	st_limit integer = student_limit;
	msg character varying;

BEGIN
	if(st_limit >= 2) then
		insert into study_groups values(default,meet_id,subject,details,student_limit, created_at, is_active);
		msg = 'successfully inserted';
	else
		msg = 'Minimum student limit 2';
	end if;
	return msg;
END;
$$;
 �   DROP FUNCTION public.create_study_group(meet_id integer, subject text, details text, student_limit integer, created_at timestamp with time zone, is_active boolean);
       public          postgres    false            �            1255    24689    edit_group(integer)    FUNCTION     ]  CREATE FUNCTION public.edit_group(group_id integer) RETURNS TABLE(sg_id integer, meet_id integer, subject character varying, details character varying, student_limit smallint, created timestamp with time zone, isactive boolean)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT * FROM study_groups WHERE study_group_id = group_id;
END;
$$;
 3   DROP FUNCTION public.edit_group(group_id integer);
       public          postgres    false            �            1255    24690    edit_meeting(integer)    FUNCTION     8  CREATE FUNCTION public.edit_meeting(meet_id integer) RETURNS TABLE(meetingid integer, place character varying, stime timestamp without time zone, etime timestamp without time zone, isactive boolean)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT *  FROM meetings WHERE meeting_id = meet_id;
END;
$$;
 4   DROP FUNCTION public.edit_meeting(meet_id integer);
       public          postgres    false            �            1255    24691    edit_student(integer)    FUNCTION     �   CREATE FUNCTION public.edit_student(stud_id integer) RETURNS TABLE(studentid integer, studentname character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT student_id, student_name  FROM students WHERE student_id = stud_id;
END;
$$;
 4   DROP FUNCTION public.edit_student(stud_id integer);
       public          postgres    false            �            1255    24692 /   fsr_login(character varying, character varying)    FUNCTION       CREATE FUNCTION public.fsr_login(sname character varying, spass character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE 
	fsr_id integer;
BEGIN
	fsr_id := (SELECT fsr_if_id FROM fsr_if where fsr_if_username = sname AND password = spass);
	return fsr_id;
END;
$$;
 R   DROP FUNCTION public.fsr_login(sname character varying, spass character varying);
       public          postgres    false            �            1255    24693    get_all_study_groups()    FUNCTION       CREATE FUNCTION public.get_all_study_groups() RETURNS TABLE(id integer, topic character varying, description character varying, group_member_limit smallint, meeting_place character varying, start_date timestamp without time zone, end_date timestamp without time zone)
    LANGUAGE plpgsql
    AS $$
DECLARE
	no_of_student int;
	i integer;
	all_group_id integer[] = (select array_agg(study_groups.study_group_id) from study_groups);
BEGIN
	FOREACH i IN ARRAY all_group_id
	LOOP
		perform change_status_overload_group(i);
	END LOOP;
	RETURN QUERY
	SELECT sg.study_group_id, sg.topic, sg.description, sg.group_member_limit,
	meet.meeting_place, meet.start_time, meet.end_time
	from study_groups sg
	join meetings meet on sg.meeting_id = meet.meeting_id
	where sg.status = '1';
END;
$$;
 -   DROP FUNCTION public.get_all_study_groups();
       public          postgres    false            �            1255    24694    get_all_study_groups(integer)    FUNCTION     L  CREATE FUNCTION public.get_all_study_groups(incoming_meet_id integer) RETURNS TABLE(id integer, topic character varying, description character varying, group_member_limit smallint, meeting_place character varying, start_date timestamp without time zone, end_date timestamp without time zone)
    LANGUAGE plpgsql
    AS $$
DECLARE
	no_of_student int;
	i integer;
	all_group_id integer[] = (select array_agg(study_groups.study_group_id) from study_groups);
BEGIN
	FOREACH i IN ARRAY all_group_id
	LOOP
		perform change_status_overload_group(i);
	END LOOP;
	RETURN QUERY
	SELECT sg.study_group_id, sg.topic, sg.description, sg.group_member_limit,
	meet.meeting_place, meet.start_time, meet.end_time
	from study_groups sg
	join meetings meet on sg.meeting_id = meet.meeting_id
	where sg.status = '1' AND sg.meeting_id = incoming_meet_id;
END;
$$;
 E   DROP FUNCTION public.get_all_study_groups(incoming_meet_id integer);
       public          postgres    false            �            1255    24695    get_meeting_detail(integer)    FUNCTION     @  CREATE FUNCTION public.get_meeting_detail(meetingid integer) RETURNS integer[]
    LANGUAGE plpgsql
    AS $$
DECLARE
	i integer = 0;
	b integer;
	each_group integer[];
	no_of_groups integer = (select count(*) from study_groups where meeting_id = meetingid);
	a integer[] = (select array_agg(study_groups.study_group_id) from study_groups where meeting_id = meetingid);
BEGIN
		FOREACH i IN ARRAY a
		LOOP
			each_group = (select array_agg(student_id) from group_members where study_group_id = i);
			raise notice '%',each_group;
			
		END LOOP;
		return each_group;
END;
$$;
 <   DROP FUNCTION public.get_meeting_detail(meetingid integer);
       public          postgres    false            �            1255    24696    get_meeting_details(integer)    FUNCTION     �  CREATE FUNCTION public.get_meeting_details(meetingid integer) RETURNS TABLE(study_group_id integer, topic character varying, student_limit smallint, description character varying, no_of_student bigint, joined_stuents character varying[])
    LANGUAGE plpgsql
    AS $$
BEGIN

	RETURN QUERY
	SELECT
	sg.study_group_id,
	sg.topic,
	sg.group_member_limit,
	sg.description,
	(SELECT COUNT(*)
	 FROM group_members gm
	 WHERE sg.study_group_id = gm.study_group_id) AS no_of_students,
	 (SELECT ARRAY_AGG(s.student_name)
		FROM group_members gm JOIN
			 students s
			 ON gm.student_id = s.student_id
		WHERE sg.study_group_id = gm.study_group_id
	 ) AS student_names
	FROM 
		study_groups sg
	WHERE 
		sg.meeting_id = meetingid;
END;
$$;
 =   DROP FUNCTION public.get_meeting_details(meetingid integer);
       public          postgres    false            �            1255    24697    get_meeting_overview()    FUNCTION     f  CREATE FUNCTION public.get_meeting_overview() RETURNS TABLE(id integer, location character varying, start_time timestamp without time zone, end_time timestamp without time zone, is_active boolean, no_of_groups bigint, no_of_student bigint)
    LANGUAGE plpgsql
    AS $$
BEGIN
	UPDATE meetings
	SET  status = '0'
	WHERE meetings.end_time <= now();
	RETURN QUERY
	SELECT meetings.meeting_id, meetings.meeting_place, meetings.start_time, meetings.end_time, meetings.status,
	(SELECT COUNT(study_groups.study_group_id) FROM study_groups 
		WHERE meetings.meeting_id = study_groups.meeting_id) AS no_of_groups, 
	(SELECT count(group_members.student_id) FROM group_members, study_groups WHERE group_members.study_group_id = study_groups.study_group_id AND study_groups.meeting_id = meetings.meeting_id) AS no_of_students FROM meetings
	where meetings.status = '1';

END;
$$;
 -   DROP FUNCTION public.get_meeting_overview();
       public          postgres    false            �            1255    24698 1   get_meeting_overview(timestamp without time zone)    FUNCTION       CREATE FUNCTION public.get_meeting_overview(currenttime timestamp without time zone) RETURNS TABLE(id integer, location character varying, start_time timestamp without time zone, end_time timestamp without time zone, is_active boolean, no_of_groups bigint, no_of_student bigint)
    LANGUAGE plpgsql
    AS $$
Declare
	ntime timestamp without time zone := (select LOCALTIMESTAMP);
BEGIN
	
	UPDATE meetings
	SET  status = '0'
	WHERE meetings.end_time <= currenttime;
	--select * from meetings WHERE meetings.end_time <= now();
	RETURN QUERY
	SELECT meetings.meeting_id, meetings.meeting_place, meetings.start_time, meetings.end_time, meetings.status,
	(SELECT COUNT(study_groups.study_group_id) FROM study_groups 
		WHERE meetings.meeting_id = study_groups.meeting_id) AS no_of_groups, 
	(SELECT count(group_members.student_id) FROM group_members, study_groups WHERE group_members.study_group_id = study_groups.study_group_id AND study_groups.meeting_id = meetings.meeting_id) AS no_of_students FROM meetings
	where meetings.status = '1';

END;
$$;
 T   DROP FUNCTION public.get_meeting_overview(currenttime timestamp without time zone);
       public          postgres    false            �            1255    24699 #   get_single_meeting_details(integer)    FUNCTION     ~  CREATE FUNCTION public.get_single_meeting_details(meetingid integer) RETURNS TABLE(g_id integer, mid integer, subject character varying, details character varying, limits smallint, created timestamp with time zone, sid integer, sname character varying)
    LANGUAGE plpgsql
    AS $$
declare
BEGIN
	RETURN QUERY
	select sg.study_group_id, sg.meeting_id, sg.topic, sg.description, sg.group_member_limit, sg.created_on, gm.student_id, st.student_name from study_groups sg inner join group_members gm on sg.study_group_id = gm.study_group_id
	inner join students st on st.student_id = gm.student_id where sg.meeting_id = meetingid;
END;
$$;
 D   DROP FUNCTION public.get_single_meeting_details(meetingid integer);
       public          postgres    false            �            1255    24700    group_owner(integer)    FUNCTION     s  CREATE FUNCTION public.group_owner(stud_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
	owner_id int;
	group_id int;
BEGIN
	group_id := (SELECT study_group_id FROM group_members WHERE student_id = stud_id);
	owner_id := (SELECT student_id FROM group_members WHERE study_group_id = group_id
	ORDER BY joined_at ASC LIMIT 1);
	RETURN owner_id;
END;
$$;
 3   DROP FUNCTION public.group_owner(stud_id integer);
       public          postgres    false            �            1255    24701 t   insert_update_meeting(character varying, timestamp with time zone, timestamp with time zone, boolean, text, integer)    FUNCTION     �  CREATE FUNCTION public.insert_update_meeting(place character varying, start_time timestamp with time zone, end_time timestamp with time zone, status boolean, operationname text, meetingid integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE
	s_date timestamp with time zone = start_time;
	e_date timestamp with time zone = end_time;
	sys_date timestamp with time zone = now();
	is_active BOOLEAN;
	message character varying;

BEGIN
	IF operationName = 'insert' THEN
	    IF ((s_date<e_date) AND (s_date>=sys_date)) THEN
	    	is_active = '0';
	    	INSERT INTO meetings(meeting_place, start_time, end_time, status) VALUES(place, start_time, end_time, status);
	    	message = 'Successfully inserted';
	    ELSE
	    	message = 'Failed to insert.';
	    END IF;
  	ELSEIF operationName = 'update' THEN
  		IF ((s_date<e_date) AND (s_date>sys_date OR s_date=sys_date)) THEN
	    	UPDATE meetings 
	    		SET meeting_place = place, start_time = s_date, end_time = e_date, status = '1'
	    		WHERE meeting_id = meetingID;
	    	message = 'Successfully updated.';
	    ELSE
	    	message = 'Failed to update.';
	    END IF;
	ELSE 
		message = 'No Insert or update.';
  	END IF;
  	return message;
END;
$$;
 �   DROP FUNCTION public.insert_update_meeting(place character varying, start_time timestamp with time zone, end_time timestamp with time zone, status boolean, operationname text, meetingid integer);
       public          postgres    false            �            1255    24702 "   join_study_group(integer, integer)    FUNCTION     �  CREATE FUNCTION public.join_study_group(stud_id integer, group_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE
	msg character varying;
	is_exist int;
	old_group_id int = (select study_group_id from group_members where student_id = stud_id);
	group_exist int = (SELECT COUNT(*) FROM group_members WHERE study_group_id = old_group_id);
BEGIN
	is_exist = (SELECT COUNT(*) FROM group_members 
		WHERE group_members.student_id = stud_id);
	
	if(is_exist = 0) then
		insert into group_members values(group_id, stud_id, now(), default);
		msg = 'successfully joined';
	else
		DELETE FROM group_members 
		WHERE group_members.student_id = stud_id;
		insert into group_members values(group_id, stud_id, now(), default);
		msg = 'successfully changed group';
			IF (group_exist = 1) THEN
				DELETE FROM study_groups  
				WHERE study_groups.study_group_id = old_group_id;
			END IF;
	end if;
	return msg;
END;
$$;
 J   DROP FUNCTION public.join_study_group(stud_id integer, group_id integer);
       public          postgres    false            �            1255    24703    leave_member(integer, integer)    FUNCTION       CREATE FUNCTION public.leave_member(stud_id integer, new_group_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE 
	no_of_student int;
	msg character varying;
	old_group_id int = (select study_group_id from group_members where student_id = stud_id);
BEGIN
	no_of_student = (SELECT COUNT(*) FROM group_members 
		WHERE group_members.study_group_id = old_group_id);
	IF (no_of_student = 1) THEN
		DELETE FROM study_groups  
		WHERE study_groups.study_group_id = new_group_id;
		delete from group_members 
		where study_group_id = new_group_id AND student_id = stud_id;
		msg = 'group has been deleted';
	elsif (new_group_id = old_group_id) then
		delete from group_members 
		where study_group_id = new_group_id AND student_id = stud_id;
		msg = 'group member has been deleted';
	--ELSE
	--	DELETE FROM group_members 
	--	WHERE group_members.student_id = stud_id;
	--	insert into group_members values(new_group_id, stud_id, now());
	--	msg = 'member deleted successfully';
	END IF;
	RETURN msg;
END;
$$;
 J   DROP FUNCTION public.leave_member(stud_id integer, new_group_id integer);
       public          postgres    false            �            1255    24704    only_hidden_meeting_list()    FUNCTION     [  CREATE FUNCTION public.only_hidden_meeting_list() RETURNS TABLE(meet_id integer, place character varying, s_time timestamp without time zone, e_time timestamp without time zone)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT meeting_id,meeting_place,start_time,end_time FROM meetings
	WHERE status = 'f' and end_time > now();
END;
$$;
 1   DROP FUNCTION public.only_hidden_meeting_list();
       public          postgres    false            �            1255    24705    only_visible_meeting_list()    FUNCTION     G  CREATE FUNCTION public.only_visible_meeting_list() RETURNS TABLE(meet_id integer, place character varying, s_time timestamp without time zone, e_time timestamp without time zone)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT meeting_id,meeting_place,start_time,end_time FROM meetings
	WHERE status = 't';
END;
$$;
 2   DROP FUNCTION public.only_visible_meeting_list();
       public          postgres    false            �            1255    24706    past_meeting_list()    FUNCTION     T  CREATE FUNCTION public.past_meeting_list() RETURNS TABLE(meet_id integer, place character varying, s_time timestamp without time zone, e_time timestamp without time zone)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT meeting_id,meeting_place,start_time,end_time FROM meetings
	WHERE status = 'f' and end_time < now();
END;
$$;
 *   DROP FUNCTION public.past_meeting_list();
       public          postgres    false            �            1255    24707    remove_meeting(integer)    FUNCTION     �  CREATE FUNCTION public.remove_meeting(meetingid integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
DECLARE 
	isActive BOOLEAN;
	-- group_member_id int = (select group_member_id from group_members WHERE group_members.meeting_id = meetingID);
	study_group_id int = (select study_group_id from study_groups WHERE study_groups.meeting_id = meetingID);
	msg character varying;
BEGIN
	isActive := (SELECT status FROM meetings where meetings.meeting_id = meetingID);
	IF (isActive!='1') THEN
		-- IF (group_member_id) THEN
		-- DELETE FROM group_members WHERE group_members.meeting_id = meetingID;
		-- END IF;
		-- IF (study_group_id) THEN
		-- DELETE FROM study_groups WHERE study_groups.meeting_id = meetingID;
		-- END IF;
		DELETE FROM meetings WHERE meetings.meeting_id = meetingID;
		msg = 'The meeting has deleted with related data.';
	ELSE
		msg = 'This meeting is active.';
	END IF;
	RETURN msg;
END;
$$;
 8   DROP FUNCTION public.remove_meeting(meetingid integer);
       public          postgres    false            �            1255    24708    student_details_all(integer)    FUNCTION     �  CREATE FUNCTION public.student_details_all(stud_id integer) RETURNS TABLE(studentid integer, studentname character varying, username character varying, pass character varying, student_created timestamp with time zone, groupid integer, sid integer, sg_join timestamp without time zone, gmid bigint, grp_id integer, meetid integer, subject character varying, details character varying, limits smallint, study_created timestamp with time zone, sgstatus boolean, meet_id integer, meetplace character varying, stime timestamp without time zone, etime timestamp without time zone, mstatus boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query
	select * from students s 
	inner join group_members gm 
	on s.student_id = gm.student_id
	inner join study_groups sg
	on gm.study_group_id = sg.study_group_id
	inner join meetings me
	on sg.meeting_id = me.meeting_id
	where s.student_id = stud_id;
end;
$$;
 ;   DROP FUNCTION public.student_details_all(stud_id integer);
       public          postgres    false            �            1255    24709 3   student_login(character varying, character varying)    FUNCTION       CREATE FUNCTION public.student_login(sname character varying, spass character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE 
	s_id integer;
BEGIN
	s_id := (SELECT student_id FROM students where student_username = sname AND password = spass);
	return s_id;
END;
$$;
 V   DROP FUNCTION public.student_login(sname character varying, spass character varying);
       public          postgres    false            �            1255    24710 3   update_group(integer, integer, text, text, integer)    FUNCTION     �  CREATE FUNCTION public.update_group(group_id integer, incoming_id integer, subject text, details text, max_student integer DEFAULT 32767) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
declare
	group_owner int = (select group_members.student_id from group_members where group_members.study_group_id = group_id
	ORDER BY joined_at ASC LIMIT 1);
	message text;
begin
	if(group_owner = incoming_id AND max_student>=2) then
		update study_groups
		set topic = subject,
			description = details,
			group_member_limit = max_student
		where study_group_id = group_id;
		message = 'successfully updated';
		
	else
		message = 'Permission denied';
	end if;
	return message;
end;
$$;
 {   DROP FUNCTION public.update_group(group_id integer, incoming_id integer, subject text, details text, max_student integer);
       public          postgres    false            �            1255    24711 `   update_meeting(integer, text, timestamp without time zone, timestamp without time zone, boolean)    FUNCTION     Y  CREATE FUNCTION public.update_meeting(meet_id integer, place text, stime timestamp without time zone, etime timestamp without time zone, isactive boolean) RETURNS void
    LANGUAGE plpgsql
    AS $$
begin
	update meetings 
	set meeting_place = place, start_time = stime, end_time = etime, status = isActive
	where meeting_id = meet_id;
end;
$$;
 �   DROP FUNCTION public.update_meeting(meet_id integer, place text, stime timestamp without time zone, etime timestamp without time zone, isactive boolean);
       public          postgres    false            �            1255    24712    update_meeting_status(integer)    FUNCTION     �   CREATE FUNCTION public.update_meeting_status(meet_id integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
begin
	update meetings 
	set status = '1'
	where meeting_id = meet_id;
end;
$$;
 =   DROP FUNCTION public.update_meeting_status(meet_id integer);
       public          postgres    false            �            1255    24713    update_student(integer, text)    FUNCTION     �   CREATE FUNCTION public.update_student(stud_id integer, stud_name text) RETURNS void
    LANGUAGE plpgsql
    AS $$
begin
	update students set student_name = stud_name where student_id = stud_id;
end;
$$;
 F   DROP FUNCTION public.update_student(stud_id integer, stud_name text);
       public          postgres    false            �            1259    24714    fsr_if    TABLE     �   CREATE TABLE public.fsr_if (
    fsr_if_id integer NOT NULL,
    fsr_if_username character varying(255) NOT NULL,
    password character varying(50) NOT NULL,
    created_on timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.fsr_if;
       public         heap    postgres    false            �            1259    24718    fsr_if_fsr_if_id_seq    SEQUENCE     �   CREATE SEQUENCE public.fsr_if_fsr_if_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.fsr_if_fsr_if_id_seq;
       public          postgres    false    200                       0    0    fsr_if_fsr_if_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.fsr_if_fsr_if_id_seq OWNED BY public.fsr_if.fsr_if_id;
          public          postgres    false    201            �            1259    24720    group_members    TABLE     �   CREATE TABLE public.group_members (
    study_group_id integer NOT NULL,
    student_id integer NOT NULL,
    joined_at timestamp without time zone NOT NULL,
    group_member_id bigint NOT NULL
);
 !   DROP TABLE public.group_members;
       public         heap    postgres    false            �            1259    24723 !   group_members_group_member_id_seq    SEQUENCE     �   CREATE SEQUENCE public.group_members_group_member_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE public.group_members_group_member_id_seq;
       public          postgres    false    202                       0    0 !   group_members_group_member_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE public.group_members_group_member_id_seq OWNED BY public.group_members.group_member_id;
          public          postgres    false    203            �            1259    24725    meetings    TABLE     �   CREATE TABLE public.meetings (
    meeting_id integer NOT NULL,
    meeting_place character varying(255) NOT NULL,
    start_time timestamp without time zone NOT NULL,
    end_time timestamp without time zone NOT NULL,
    status boolean NOT NULL
);
    DROP TABLE public.meetings;
       public         heap    postgres    false            �            1259    24728    meetings_meeting_id_seq    SEQUENCE     �   CREATE SEQUENCE public.meetings_meeting_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.meetings_meeting_id_seq;
       public          postgres    false    204                       0    0    meetings_meeting_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.meetings_meeting_id_seq OWNED BY public.meetings.meeting_id;
          public          postgres    false    205            �            1259    24730    students    TABLE       CREATE TABLE public.students (
    student_id integer NOT NULL,
    student_name character varying(50) NOT NULL,
    student_username character varying(255) NOT NULL,
    password character varying(50) NOT NULL,
    created_on timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.students;
       public         heap    postgres    false            �            1259    24734    students_student_id_seq    SEQUENCE     �   CREATE SEQUENCE public.students_student_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.students_student_id_seq;
       public          postgres    false    206            	           0    0    students_student_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.students_student_id_seq OWNED BY public.students.student_id;
          public          postgres    false    207            �            1259    24736    study_groups    TABLE     W  CREATE TABLE public.study_groups (
    study_group_id integer NOT NULL,
    meeting_id integer NOT NULL,
    topic character varying(255) NOT NULL,
    description character varying(1023) NOT NULL,
    group_member_limit smallint DEFAULT 32767 NOT NULL,
    created_on timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    status boolean
);
     DROP TABLE public.study_groups;
       public         heap    postgres    false            �            1259    24744    study_groups_study_group_id_seq    SEQUENCE     �   CREATE SEQUENCE public.study_groups_study_group_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.study_groups_study_group_id_seq;
       public          postgres    false    208            
           0    0    study_groups_study_group_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.study_groups_study_group_id_seq OWNED BY public.study_groups.study_group_id;
          public          postgres    false    209            [           2604    24746    fsr_if fsr_if_id    DEFAULT     t   ALTER TABLE ONLY public.fsr_if ALTER COLUMN fsr_if_id SET DEFAULT nextval('public.fsr_if_fsr_if_id_seq'::regclass);
 ?   ALTER TABLE public.fsr_if ALTER COLUMN fsr_if_id DROP DEFAULT;
       public          postgres    false    201    200            \           2604    24747    group_members group_member_id    DEFAULT     �   ALTER TABLE ONLY public.group_members ALTER COLUMN group_member_id SET DEFAULT nextval('public.group_members_group_member_id_seq'::regclass);
 L   ALTER TABLE public.group_members ALTER COLUMN group_member_id DROP DEFAULT;
       public          postgres    false    203    202            ]           2604    24748    meetings meeting_id    DEFAULT     z   ALTER TABLE ONLY public.meetings ALTER COLUMN meeting_id SET DEFAULT nextval('public.meetings_meeting_id_seq'::regclass);
 B   ALTER TABLE public.meetings ALTER COLUMN meeting_id DROP DEFAULT;
       public          postgres    false    205    204            _           2604    24749    students student_id    DEFAULT     z   ALTER TABLE ONLY public.students ALTER COLUMN student_id SET DEFAULT nextval('public.students_student_id_seq'::regclass);
 B   ALTER TABLE public.students ALTER COLUMN student_id DROP DEFAULT;
       public          postgres    false    207    206            b           2604    24750    study_groups study_group_id    DEFAULT     �   ALTER TABLE ONLY public.study_groups ALTER COLUMN study_group_id SET DEFAULT nextval('public.study_groups_study_group_id_seq'::regclass);
 J   ALTER TABLE public.study_groups ALTER COLUMN study_group_id DROP DEFAULT;
       public          postgres    false    209    208            �          0    24714    fsr_if 
   TABLE DATA           R   COPY public.fsr_if (fsr_if_id, fsr_if_username, password, created_on) FROM stdin;
    public          postgres    false    200   F�       �          0    24720    group_members 
   TABLE DATA           _   COPY public.group_members (study_group_id, student_id, joined_at, group_member_id) FROM stdin;
    public          postgres    false    202   ��       �          0    24725    meetings 
   TABLE DATA           [   COPY public.meetings (meeting_id, meeting_place, start_time, end_time, status) FROM stdin;
    public          postgres    false    204    �       �          0    24730    students 
   TABLE DATA           d   COPY public.students (student_id, student_name, student_username, password, created_on) FROM stdin;
    public          postgres    false    206   Ϝ       �          0    24736    study_groups 
   TABLE DATA           ~   COPY public.study_groups (study_group_id, meeting_id, topic, description, group_member_limit, created_on, status) FROM stdin;
    public          postgres    false    208   ��                  0    0    fsr_if_fsr_if_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.fsr_if_fsr_if_id_seq', 1, true);
          public          postgres    false    201                       0    0 !   group_members_group_member_id_seq    SEQUENCE SET     Q   SELECT pg_catalog.setval('public.group_members_group_member_id_seq', 141, true);
          public          postgres    false    203                       0    0    meetings_meeting_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.meetings_meeting_id_seq', 89, true);
          public          postgres    false    205                       0    0    students_student_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.students_student_id_seq', 45, true);
          public          postgres    false    207                       0    0    study_groups_study_group_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.study_groups_study_group_id_seq', 70, true);
          public          postgres    false    209            d           2606    24752 !   fsr_if fsr_if_fsr_if_username_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.fsr_if
    ADD CONSTRAINT fsr_if_fsr_if_username_key UNIQUE (fsr_if_username);
 K   ALTER TABLE ONLY public.fsr_if DROP CONSTRAINT fsr_if_fsr_if_username_key;
       public            postgres    false    200            f           2606    24754    fsr_if fsr_if_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.fsr_if
    ADD CONSTRAINT fsr_if_pkey PRIMARY KEY (fsr_if_id);
 <   ALTER TABLE ONLY public.fsr_if DROP CONSTRAINT fsr_if_pkey;
       public            postgres    false    200            h           2606    24756     group_members group_members_pkey 
   CONSTRAINT     k   ALTER TABLE ONLY public.group_members
    ADD CONSTRAINT group_members_pkey PRIMARY KEY (group_member_id);
 J   ALTER TABLE ONLY public.group_members DROP CONSTRAINT group_members_pkey;
       public            postgres    false    202            j           2606    24758    meetings meetings_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.meetings
    ADD CONSTRAINT meetings_pkey PRIMARY KEY (meeting_id);
 @   ALTER TABLE ONLY public.meetings DROP CONSTRAINT meetings_pkey;
       public            postgres    false    204            l           2606    24760    students students_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_pkey PRIMARY KEY (student_id);
 @   ALTER TABLE ONLY public.students DROP CONSTRAINT students_pkey;
       public            postgres    false    206            n           2606    24762 &   students students_student_username_key 
   CONSTRAINT     m   ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_student_username_key UNIQUE (student_username);
 P   ALTER TABLE ONLY public.students DROP CONSTRAINT students_student_username_key;
       public            postgres    false    206            p           2606    24764    study_groups study_groups_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.study_groups
    ADD CONSTRAINT study_groups_pkey PRIMARY KEY (study_group_id);
 H   ALTER TABLE ONLY public.study_groups DROP CONSTRAINT study_groups_pkey;
       public            postgres    false    208            s           2606    24765    study_groups fk_meeting    FK CONSTRAINT     �   ALTER TABLE ONLY public.study_groups
    ADD CONSTRAINT fk_meeting FOREIGN KEY (meeting_id) REFERENCES public.meetings(meeting_id) ON DELETE CASCADE;
 A   ALTER TABLE ONLY public.study_groups DROP CONSTRAINT fk_meeting;
       public          postgres    false    208    2922    204            q           2606    24770    group_members fk_student    FK CONSTRAINT     �   ALTER TABLE ONLY public.group_members
    ADD CONSTRAINT fk_student FOREIGN KEY (student_id) REFERENCES public.students(student_id) ON DELETE CASCADE;
 B   ALTER TABLE ONLY public.group_members DROP CONSTRAINT fk_student;
       public          postgres    false    2924    206    202            r           2606    24775    group_members fk_study_group    FK CONSTRAINT     �   ALTER TABLE ONLY public.group_members
    ADD CONSTRAINT fk_study_group FOREIGN KEY (study_group_id) REFERENCES public.study_groups(study_group_id) ON DELETE CASCADE;
 F   ALTER TABLE ONLY public.group_members DROP CONSTRAINT fk_study_group;
       public          postgres    false    208    2928    202            �   3   x�3�LL��̃�FF����F
F�V&V��zF�f���F\1z\\\ 2�
�      �   g   x�]̱�@��P���Z�Ƒ��wEF&���[����\�Qj��n��ZvV ���P��cx�|I��,g��C���~�\"S4|� �����w3 M      �   �   x�]��� Ek����b��>��uc(�!�/����{f�b$;��7�r�B��(�
�Jh�]��Δ	,՗En��o}x~]!��ܦ�B�l�gI.��vxDR��b*�$�Y�Ū>�N��1U�N(ffbb��1�u
��ѽ<y�r6}�~���v:Ce�w��y%5�2��]ל���P%      �     x�}ѿj�0����K��N�7?@!�S�˅l����k����5�����'IÇ�� �%51�e�B�GtG��d�b�����z�`�c[�D��t�8�v��o����`¨l`G�(��2w˭�۸�1��:�l
�ОsE9o��b��r�b<��\�RǦc���}a޻�g��������p����%�%��!E[�P#��\Ar<G��餃��c5N���ul��廌�.ֆ���N�K>s္`L&*(��a��r�a��n�(���+�TM�����<      �   �   x�m��N�0���S�^�r|����Բ11����UMӤJ\��(Tj�p�I���wZ+�Ē����K��yj�ӄe�p����i�SS�bˠ���Ү%c탴A�0�ڛ�TP*��OxI8箻A^a��сXh6�V����m�3��)�d����E� ���>�P�`8���#�����a<.�>�R�w��%=ƾŏ4^���c*���!�V2���~UU}��ZJ     