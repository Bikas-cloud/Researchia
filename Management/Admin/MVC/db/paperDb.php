<?php

function getAllPapers($conn, $journal_id = null)
{
    $sql = "
        SELECT 
            p.paper_id,
            p.title,
            p.abstract,
            p.status,
            p.submission_date,
            pv.file_path,
            j.journal_name,
            u.name AS author_name,

            ra.reviewer_id,
            r.name AS reviewer_name

        FROM papers p

        INNER JOIN users u ON p.user_id = u.user_id
        INNER JOIN journals j ON p.journal_id = j.journal_id

        LEFT JOIN paper_versions pv 
            ON pv.paper_id = p.paper_id 
            AND pv.version_number = (
                SELECT MAX(version_number) 
                FROM paper_versions 
                WHERE paper_id = p.paper_id
            )

        LEFT JOIN reviewer_assignment ra ON p.paper_id = ra.paper_id
        LEFT JOIN reviewers r ON ra.reviewer_id = r.reviewer_id
    ";


    return $conn->query($sql);
}
