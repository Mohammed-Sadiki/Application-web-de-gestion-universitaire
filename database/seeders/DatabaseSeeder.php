<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Department;
use App\Models\Group;
use App\Models\Room;
use App\Models\Module;
use App\Models\Professor;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Absence;
use App\Models\LessonLog;
use App\Models\CourseMaterial;
use App\Models\Announcement;
use App\Models\RoomReservation;
use App\Models\AdministrativeRequest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Departments
        $deptNames = [
            'Génie Informatique',
            'Génie Civil',
            'Génie Industriel',
            'Génie Électrique',
            'Management & Finance'
        ];
        $departments = [];
        foreach ($deptNames as $name) {
            $departments[] = Department::create(['name' => $name]);
        }

        // 2. Groups
        $groupNames = [
            ['name' => 'GINFO3A', 'dept_idx' => 0],
            ['name' => 'GINFO3B', 'dept_idx' => 0],
            ['name' => 'GCIV3A', 'dept_idx' => 1],
            ['name' => 'GIND3A', 'dept_idx' => 2],
            ['name' => 'GELEC3A', 'dept_idx' => 3],
        ];
        $groups = [];
        foreach ($groupNames as $g) {
            $groups[] = Group::create([
                'name' => $g['name'],
                'department_id' => $departments[$g['dept_idx']]->id
            ]);
        }

        // 3. Rooms
        $roomData = [
            ['name' => 'Amphi A', 'capacity' => 120],
            ['name' => 'Salle 101', 'capacity' => 40],
            ['name' => 'Salle 102', 'capacity' => 40],
            ['name' => 'Labo Info 1', 'capacity' => 25],
            ['name' => 'Labo Info 2', 'capacity' => 25],
        ];
        $rooms = [];
        foreach ($roomData as $r) {
            $rooms[] = Room::create($r);
        }

        // 4. Modules
        $moduleData = [
            ['name' => 'Technologie Web 2', 'dept_idx' => 0],
            ['name' => 'Base de Données Relationnelles', 'dept_idx' => 0],
            ['name' => 'Intelligence Artificielle', 'dept_idx' => 0],
            ['name' => 'Analyse Numérique', 'dept_idx' => 0],
            ['name' => 'Réseaux & Sécurité', 'dept_idx' => 0],
        ];
        $modules = [];
        foreach ($moduleData as $m) {
            $modules[] = Module::create([
                'name' => $m['name'],
                'department_id' => $departments[$m['dept_idx']]->id
            ]);
        }

        // 5. Default Users & Roles
        // Admin
        $adminUser = User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@upf.ac.ma',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Professors
        $profUsersData = [
            ['name' => 'Pr. Marwane KZADRI', 'email' => 'professor@upf.ac.ma', 'specialty' => 'Web & Génie Logiciel'],
            ['name' => 'Pr. Ahmed ALAMI', 'email' => 'alami@upf.ac.ma', 'specialty' => 'Réseaux'],
            ['name' => 'Pr. Fatima BENNANI', 'email' => 'bennani@upf.ac.ma', 'specialty' => 'Intelligence Artificielle'],
            ['name' => 'Pr. Khalid SEFRIOUI', 'email' => 'sefrioui@upf.ac.ma', 'specialty' => 'Mathématiques Appliquées'],
            ['name' => 'Pr. Sanae TOUIMI', 'email' => 'touimi@upf.ac.ma', 'specialty' => 'Base de données'],
        ];

        $professors = [];
        foreach ($profUsersData as $idx => $p) {
            $user = User::factory()->create([
                'name' => $p['name'],
                'email' => $p['email'],
                'password' => bcrypt('password'),
                'role' => 'professor',
            ]);
            $professors[] = Professor::create([
                'user_id' => $user->id,
                'specialty' => $p['specialty']
            ]);
        }

        // Associate modules to professors
        $professors[0]->modules()->attach([$modules[0]->id]); // KZADRI -> Web
        $professors[1]->modules()->attach([$modules[4]->id]); // ALAMI -> Réseaux
        $professors[2]->modules()->attach([$modules[2]->id]); // BENNANI -> IA
        $professors[3]->modules()->attach([$modules[3]->id]); // SEFRIOUI -> Maths
        $professors[4]->modules()->attach([$modules[1]->id]); // TOUIMI -> BDD

        // Students
        $studentUsersData = [
            ['name' => 'Anass EL HASSANI', 'email' => 'student@upf.ac.ma', 'cne' => 'N134567890', 'group_idx' => 0],
            ['name' => 'Yassine BELKADIR', 'email' => 'belkadir@upf.ac.ma', 'cne' => 'N134567891', 'group_idx' => 0],
            ['name' => 'Salma TAZI', 'email' => 'tazi@upf.ac.ma', 'cne' => 'N134567892', 'group_idx' => 0],
            ['name' => 'Othmane BENJELLOUN', 'email' => 'benjelloun@upf.ac.ma', 'cne' => 'N134567893', 'group_idx' => 1],
            ['name' => 'Khadija MANSOURI', 'email' => 'mansouri@upf.ac.ma', 'cne' => 'N134567894', 'group_idx' => 1],
        ];

        $students = [];
        foreach ($studentUsersData as $idx => $s) {
            $user = User::factory()->create([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => bcrypt('password'),
                'role' => 'student',
            ]);
            $studentModel = Student::create([
                'user_id' => $user->id,
                'group_id' => $groups[$s['group_idx']]->id,
                'cne' => $s['cne']
            ]);
            // Attach student to all modules
            $studentModel->modules()->attach([
                $modules[0]->id,
                $modules[1]->id,
                $modules[2]->id,
                $modules[3]->id,
                $modules[4]->id
            ]);
            $students[] = $studentModel;
        }

        // 6. Schedules (At least 5)
        $scheduleData = [
            ['group_id' => $groups[0]->id, 'module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'room_id' => $rooms[3]->id, 'day' => 'Monday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
            ['group_id' => $groups[0]->id, 'module_id' => $modules[1]->id, 'professor_id' => $professors[4]->id, 'room_id' => $rooms[1]->id, 'day' => 'Tuesday', 'start_time' => '14:00:00', 'end_time' => '17:00:00'],
            ['group_id' => $groups[0]->id, 'module_id' => $modules[2]->id, 'professor_id' => $professors[2]->id, 'room_id' => $rooms[4]->id, 'day' => 'Wednesday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
            ['group_id' => $groups[0]->id, 'module_id' => $modules[3]->id, 'professor_id' => $professors[3]->id, 'room_id' => $rooms[2]->id, 'day' => 'Thursday', 'start_time' => '14:00:00', 'end_time' => '17:00:00'],
            ['group_id' => $groups[0]->id, 'module_id' => $modules[4]->id, 'professor_id' => $professors[1]->id, 'room_id' => $rooms[1]->id, 'day' => 'Friday', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
        ];
        foreach ($scheduleData as $sd) {
            Schedule::create($sd);
        }

        // 7. Grades (At least 5)
        foreach ($students as $st) {
            foreach ($modules as $mod) {
                Grade::create([
                    'student_id' => $st->id,
                    'module_id' => $mod->id,
                    'cc1' => rand(12, 18),
                    'cc2' => rand(11, 19),
                    'exam' => rand(10, 18),
                    'final_grade' => rand(11, 18)
                ]);
            }
        }

        // 8. Absences (At least 5)
        $absenceData = [
            ['student_id' => $students[0]->id, 'module_id' => $modules[0]->id, 'date' => date('Y-m-d', strtotime('-5 days')), 'justified' => true, 'justification_path' => 'justifications/certif1.pdf', 'status' => 'pending'],
            ['student_id' => $students[0]->id, 'module_id' => $modules[1]->id, 'date' => date('Y-m-d', strtotime('-4 days')), 'justified' => false, 'justification_path' => null, 'status' => 'pending'],
            ['student_id' => $students[1]->id, 'module_id' => $modules[0]->id, 'date' => date('Y-m-d', strtotime('-5 days')), 'justified' => true, 'justification_path' => 'justifications/certif2.pdf', 'status' => 'validated'],
            ['student_id' => $students[2]->id, 'module_id' => $modules[2]->id, 'date' => date('Y-m-d', strtotime('-3 days')), 'justified' => true, 'justification_path' => 'justifications/certif3.pdf', 'status' => 'rejected'],
            ['student_id' => $students[3]->id, 'module_id' => $modules[3]->id, 'date' => date('Y-m-d', strtotime('-2 days')), 'justified' => false, 'justification_path' => null, 'status' => 'pending'],
        ];
        foreach ($absenceData as $ad) {
            Absence::create($ad);
        }

        // 9. Lesson Logs (At least 5)
        $logData = [
            ['module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'date' => date('Y-m-d', strtotime('-1 week')), 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'objective' => 'Introduction aux frameworks PHP et routage Laravel.', 'type' => 'Cours'],
            ['module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'date' => date('Y-m-d', strtotime('-5 days')), 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'objective' => 'TP 1 : Création de contrôleurs et formulaires.', 'type' => 'TP'],
            ['module_id' => $modules[1]->id, 'professor_id' => $professors[4]->id, 'date' => date('Y-m-d', strtotime('-6 days')), 'start_time' => '14:00:00', 'end_time' => '17:00:00', 'objective' => 'Modèle Conceptuel de Données (MCD) et schéma relationnel.', 'type' => 'Cours'],
            ['module_id' => $modules[2]->id, 'professor_id' => $professors[2]->id, 'date' => date('Y-m-d', strtotime('-4 days')), 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'objective' => 'Algorithmes de recherche non informée et A*.', 'type' => 'TD'],
            ['module_id' => $modules[4]->id, 'professor_id' => $professors[1]->id, 'date' => date('Y-m-d', strtotime('-2 days')), 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'objective' => 'Introduction aux modèles OSI et TCP/IP.', 'type' => 'Cours'],
        ];
        foreach ($logData as $ld) {
            LessonLog::create($ld);
        }

        // 10. Course Materials (At least 5)
        $materialData = [
            ['module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'title' => 'Support de cours 1 : Introduction à Laravel', 'file_path' => 'materials/laravel_intro.pdf', 'type' => 'PDF'],
            ['module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'title' => 'Code Source TP1', 'file_path' => 'materials/tp1_src.zip', 'type' => 'ZIP'],
            ['module_id' => $modules[1]->id, 'professor_id' => $professors[4]->id, 'title' => 'Chapitre 2 : SQL et Normalisation', 'file_path' => 'materials/chapter2_sql.pdf', 'type' => 'PDF'],
            ['module_id' => $modules[2]->id, 'professor_id' => $professors[2]->id, 'title' => 'Diapositives de Recherche Graph', 'file_path' => 'materials/graph_search.pptx', 'type' => 'PPTX'],
            ['module_id' => $modules[4]->id, 'professor_id' => $professors[1]->id, 'title' => 'Supports adressage IP v4/v6', 'file_path' => 'materials/ipv4_ipv6.pdf', 'type' => 'PDF'],
        ];
        foreach ($materialData as $md) {
            CourseMaterial::create($md);
        }

        // 11. Announcements (At least 5)
        $announcementData = [
            ['module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'content' => 'Rappel : Le TP 1 doit être rendu sur GitHub avant ce soir 23h59.'],
            ['module_id' => $modules[0]->id, 'professor_id' => $professors[0]->id, 'content' => 'Le cours de lundi prochain aura lieu exceptionnellement en Amphi A.'],
            ['module_id' => $modules[1]->id, 'professor_id' => $professors[4]->id, 'content' => 'Veuillez réviser les jointures complexes pour le mini-test de mardi.'],
            ['module_id' => $modules[2]->id, 'professor_id' => $professors[2]->id, 'content' => 'Le devoir libre sur les réseaux de neurones est en ligne sur l\'espace Classroom.'],
            ['module_id' => $modules[4]->id, 'professor_id' => $professors[1]->id, 'content' => 'Séance de rattrapage programmée pour vendredi après-midi en Salle 102.'],
        ];
        foreach ($announcementData as $ad) {
            Announcement::create($ad);
        }

        // 12. Room Reservations (At least 5)
        $resData = [
            ['room_id' => $rooms[1]->id, 'professor_id' => $professors[0]->id, 'date' => date('Y-m-d', strtotime('+2 days')), 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'reason' => 'Soutenance de PFE de fin de semestre'],
            ['room_id' => $rooms[2]->id, 'professor_id' => $professors[1]->id, 'date' => date('Y-m-d', strtotime('+3 days')), 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'reason' => 'Séance de rattrapage Réseaux'],
            ['room_id' => $rooms[3]->id, 'professor_id' => $professors[2]->id, 'date' => date('Y-m-d', strtotime('+1 days')), 'start_time' => '09:00:00', 'end_time' => '11:00:00', 'reason' => 'Examen blanc Intelligence Artificielle'],
            ['room_id' => $rooms[4]->id, 'professor_id' => $professors[3]->id, 'date' => date('Y-m-d', strtotime('+4 days')), 'start_time' => '11:00:00', 'end_time' => '13:00:00', 'reason' => 'Atelier de modélisation mathématique'],
            ['room_id' => $rooms[1]->id, 'professor_id' => $professors[4]->id, 'date' => date('Y-m-d', strtotime('+5 days')), 'start_time' => '15:00:00', 'end_time' => '17:00:00', 'reason' => 'Réunion de projet de recherche'],
        ];
        foreach ($resData as $rd) {
            RoomReservation::create($rd);
        }

        // 13. Administrative Requests (At least 5)
        $reqData = [
            // Students
            ['user_id' => $students[0]->user_id, 'professor_id' => null, 'type' => 'Attestation de scolarité', 'status' => 'pending', 'reason' => null, 'file_path' => null],
            ['user_id' => $students[0]->user_id, 'professor_id' => $professors[0]->id, 'type' => 'Relevé de notes', 'status' => 'transferred', 'reason' => 'Transféré automatiquement au professeur concerné.', 'file_path' => null],
            ['user_id' => $students[1]->user_id, 'professor_id' => null, 'type' => 'Relevé de notes', 'status' => 'validated', 'reason' => null, 'file_path' => 'documents/doc_demo_notes.pdf'],
            ['user_id' => $students[2]->user_id, 'professor_id' => null, 'type' => 'Certificat d\'inscription', 'status' => 'rejected', 'reason' => 'Dossier incomplet, pièces manquantes.', 'file_path' => null],
            // Professors
            ['user_id' => $professors[0]->user_id, 'professor_id' => null, 'type' => 'Attestation de travail', 'status' => 'pending', 'reason' => null, 'file_path' => null],
            ['user_id' => $professors[1]->user_id, 'professor_id' => null, 'type' => 'Ordre de mission', 'status' => 'validated', 'reason' => json_encode(['destination' => 'Casablanca', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d', strtotime('+2 days')), 'motif' => 'Participation à la conférence nationale sur la cybersécurité.']), 'file_path' => 'documents/doc_demo_mission.pdf'],
        ];
        foreach ($reqData as $req) {
            AdministrativeRequest::create($req);
        }
    }
}
