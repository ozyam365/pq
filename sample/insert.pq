@r["subject"] = @subject
@r["note"] = @note
@r["author"] = @author
@r["reg_date"] = now()

db.bbs.insert(@r)