<?php

function checkDBConnection($mysqliConnection)
{
    try {
        if(!$mysqliConnection->connect_errno) {
            echo "DB connection works <br>";
        }
        else {
            throw new Exception("Unable to connect to ".$dbhost);
        }
    }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()." \n";
    }

}

function divideName($string)
{
    $parts = explode(" ", $string);
    $lastname = array_pop($parts);
    $firstname = implode(" ", $parts);

    return $array = [$firstname, $lastname];
}

function getUserID($string, $mysqliConnection)
{

    list($firstname, $lastname) = divideName($string);

    try {
        if ($result = $mysqliConnection->query("
        SELECT id FROM glpi_users WHERE realname='$lastname' AND firstname='$firstname'

        ")) {

            $row = $result->fetch_assoc();
            if (!is_null($row["id"])) {
                $id = $row["id"];
            }
            else {
                $result->close();
                return 0;
            }


            $result->close();
        }
        else {
            throw new Exception('Query error: '.$mysqliConnection->error." No: ".$mysqliConnection->errno);
        }
    }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }

    return $id;
}

function checkForTicketValidation($ticket_id, $user_id, $mysqliConnection)
{
     try {
        if ($result = $mysqliConnection->query("
        SELECT * FROM glpi_ticketvalidations where
        tickets_id = '$ticket_id' and
        users_id_validate = '$user_id' and
        status = '3'
	ORDER BY validation_date DESC
        "))
        {
            if ($result->num_rows != 0)
            {
                $result->close();
                return True;
            }
            else
            {
                $result->close();
                return False;
            }

        }
        else {
            throw new Exception('Query error: '.$mysqliConnection->error." No: ".$mysqliConnection->errno);
        }
    }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
}

function getTicketValidationDate($ticket_id, $user_id, $mysqliConnection)
{
    try {
        if ($result = $mysqliConnection->query("
        SELECT validation_date FROM glpi_ticketvalidations where
        tickets_id = '$ticket_id' and
        users_id_validate = '$user_id' and
        status = '3'
	ORDER BY validation_date DESC

        "))
        {
            if ($result->num_rows != 0)
            {
                $row = $result->fetch_assoc();
                $result->close();
                return $row['validation_date'];
            }
            else
            {
                $result->close();
                return False;
            }
        }
        else {
            throw new Exception('Query error: '.$mysqliConnection->error." No: ".$mysqliConnection->errno);
        }
    }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
}

function getUserGroup($userID, $mysqliConnection)
{
    try {
        if ($result = $mysqliConnection->query("
            SELECT
                glpi_groups.name
            FROM
                glpi_groups_users
            LEFT JOIN glpi_groups ON glpi_groups_users.groups_id = glpi_groups.id

            WHERE
                glpi_groups_users.users_id='$userID';
        ")) {

            $row = $result->fetch_assoc();
            if (!is_null($row["name"])) {
                $groupname = $row["name"];
            }
            else {
                    $result->close();
                    return False;
            }

            $result->close();
        }
        else {
            throw new Exception('Query error: '.$mysqliConnection->error." No: ".$mysqliConnection->errno);
        }
    }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }

    return $groupname;
}

function getUserComputers($userID, $mysqliConnection)
{
    try {
            if ($result = $mysqliConnection->query("
                SELECT
                    glpi_computertypes.name,
                    glpi_manufacturers.name,
                    glpi_computermodels.name,
                    glpi_computers.serial,
                    glpi_computers.otherserial,
                    glpi_states.name
                FROM
                    ((((glpi_computers
                    LEFT JOIN glpi_computertypes ON glpi_computers.computertypes_id = glpi_computertypes.id)
                    LEFT JOIN glpi_computermodels ON glpi_computers.computermodels_id = glpi_computermodels.id)
                    LEFT JOIN glpi_manufacturers ON glpi_computers.manufacturers_id = glpi_manufacturers.id)
                    LEFT JOIN glpi_states ON glpi_computers.states_id = glpi_states.id)
                WHERE
                    glpi_computers.users_id = '$userID' AND glpi_computers.is_deleted != 1;
            ")) {
                    if ($result->num_rows > 0) {
                           for($i = 0; $i < $result->num_rows; $i++)
                                    $array[$i] = $result->fetch_row();
                        return $array;
                    }
            }
            else {
                throw new Exception('Query error: '.$mysqliConnection->error);
            }
        }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
    return False;
}

function getUserMonitors($userID, $mysqliConnection)
{
    try {
            if ($result = $mysqliConnection->query("
                SELECT
                    glpi_monitortypes.name,
                    glpi_manufacturers.name,
                    glpi_monitormodels.name,
                    glpi_monitors.serial,
                    glpi_monitors.otherserial,
                    glpi_states.name
                FROM
                    ((((glpi_monitors
                    LEFT JOIN glpi_monitortypes ON glpi_monitors.monitortypes_id = glpi_monitortypes.id)
                    LEFT JOIN glpi_monitormodels ON glpi_monitors.monitormodels_id = glpi_monitormodels.id)
                    LEFT JOIN glpi_manufacturers ON glpi_monitors.manufacturers_id = glpi_manufacturers.id)
                    LEFT JOIN glpi_states ON glpi_monitors.states_id = glpi_states.id)
                WHERE
                    glpi_monitors.users_id='$userID' AND glpi_monitors.is_deleted != 1;
            ")) {

                if ($result->num_rows > 0) {
                           for($i = 0; $i < $result->num_rows; $i++)
                                    $array[$i] = $result->fetch_row();
                        return $array;
                    }
            }
            else {
                throw new Exception('Query error: '.$mysqliConnection->error);
            }
        }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
    return False;
}

function getUserPrinters($userID, $mysqliConnection)
{
    try {
            if ($result = $mysqliConnection->query("
                SELECT
                    glpi_printertypes.name,
                    glpi_manufacturers.name,
                    glpi_printermodels.name,
                    glpi_printers.serial,
                    glpi_printers.otherserial,
                    glpi_states.name
                FROM
                    ((((glpi_printers
                    LEFT JOIN glpi_printertypes ON glpi_printers.printertypes_id = glpi_printertypes.id)
                    LEFT JOIN glpi_printermodels ON glpi_printers.printermodels_id = glpi_printermodels.id)
                    LEFT JOIN glpi_manufacturers ON glpi_printers.manufacturers_id = glpi_manufacturers.id)
                    LEFT JOIN glpi_states ON glpi_printers.states_id = glpi_states.id)
                WHERE
                    glpi_printers.users_id = '$userID' AND glpi_printers.is_deleted != 1;
            ")) {

                if ($result->num_rows > 0) {
                           for($i = 0; $i < $result->num_rows; $i++)
                                    $array[$i] = $result->fetch_row();
                        return $array;
                    }
            }
            else {
                throw new Exception('Query error: '.$mysqliConnection->error);
            }
        }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
    return False;
}

function getUserPhones($userID, $mysqliConnection)
{
    try {
            if ($result = $mysqliConnection->query("
                SELECT
                    glpi_phonetypes.name,
                    glpi_manufacturers.name,
                    glpi_phonemodels.name,
                    glpi_phones.serial,
                    glpi_phones.otherserial,
                    glpi_states.name
                FROM
                    ((((glpi_phones
                    LEFT JOIN glpi_phonetypes ON glpi_phones.phonetypes_id = glpi_phonetypes.id)
                    LEFT JOIN glpi_phonemodels ON glpi_phones.phonemodels_id = glpi_phonemodels.id)
                    LEFT JOIN glpi_manufacturers ON glpi_phones.manufacturers_id = glpi_manufacturers.id)
                    LEFT JOIN glpi_states ON glpi_phones.states_id = glpi_states.id)
                WHERE
                    glpi_phones.users_id='$userID' AND glpi_phones.is_deleted != 1;
            ")) {

                if ($result->num_rows > 0) {
                           for($i = 0; $i < $result->num_rows; $i++)
                                    $array[$i] = $result->fetch_row();
                        return $array;
                    }
            }
            else {
                throw new Exception('Query error: '.$mysqliConnection->error);
            }
        }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
    return False;
}

function getUserNetworkDevices($userID, $mysqliConnection)
{
    try {
            if ($result = $mysqliConnection->query("
                SELECT
                    glpi_networkequipmenttypes.name,
                    glpi_manufacturers.name,
                    glpi_networkequipmentmodels.name,
                    glpi_networkequipments.serial,
                    glpi_networkequipments.otherserial,
                    glpi_states.name
                FROM
                    ((((glpi_networkequipments
                    LEFT JOIN glpi_networkequipmenttypes ON glpi_networkequipments.networkequipmenttypes_id = glpi_networkequipmenttypes.id)
                    LEFT JOIN glpi_networkequipmentmodels ON glpi_networkequipments.networkequipmentmodels_id = glpi_networkequipmentmodels.id)
                    LEFT JOIN glpi_manufacturers ON glpi_networkequipments.manufacturers_id = glpi_manufacturers.id)
                    LEFT JOIN glpi_states ON glpi_networkequipments.states_id = glpi_states.id)
                WHERE
                    glpi_networkequipments.users_id='$userID' AND glpi_networkequipments.is_deleted != 1;
            ")) {
                    if ($result->num_rows > 0) {
                           for($i = 0; $i < $result->num_rows; $i++)
                                    $array[$i] = $result->fetch_row();
                        return $array;
                    }
            }
            else {
                throw new Exception('Query error: '.$mysqliConnection->error);
            }
        }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
    return False;
}

function getUserPeripherals($userID, $mysqliConnection)
{
    try {
            if ($result = $mysqliConnection->query("
                SELECT
                    glpi_peripheraltypes.name,
                    glpi_manufacturers.name,
                    glpi_peripheralmodels.name,
                    glpi_peripherals.serial,
                    glpi_peripherals.otherserial,
                    glpi_states.name
                FROM
                    ((((glpi_peripherals
                    LEFT JOIN glpi_peripheraltypes ON glpi_peripherals.peripheraltypes_id = glpi_peripheraltypes.id)
                    LEFT JOIN glpi_peripheralmodels ON glpi_peripherals.peripheralmodels_id = glpi_peripheralmodels.id)
                    LEFT JOIN glpi_manufacturers ON glpi_peripherals.manufacturers_id = glpi_manufacturers.id)
                    LEFT JOIN glpi_states ON glpi_peripherals.states_id = glpi_states.id)
                WHERE
                    glpi_peripherals.users_id='$userID' AND glpi_peripherals.is_deleted != 1;
            ")) {

               if ($result->num_rows > 0) {
                           for($i = 0; $i < $result->num_rows; $i++)
                                    $array[$i] = $result->fetch_row();
                        return $array;
                    }
            }
            else {
                throw new Exception('Query error: '.$mysqliConnection->error);
            }
        }
    catch (Exception $e) {
        echo "Exception: ".$e->getMessage()."\n";
    }
    return False;
}
