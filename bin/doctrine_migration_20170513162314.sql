-- Doctrine Migration File Generated on 2017-05-13 16:23:14

-- Version 20170513131228
INSERT INTO `football_teams` 
                (`id`, `name`, `played_games`, `won_games`, `lost_games`, `scored_goals`, `score`) 
            VALUES 
                ('1', 'FC Lopata', '112', '12', '100', '14', '5.6'),
                ('2', 'FC Steaua', '32', '9', '25', '5', '5.6'),
                ('3', 'FC Rapid', '23', '8', '15', '8', '5.6'),
                ('4', 'FC UCJ', '32', '10', '22', '3', '5.6'),
                ('5', 'CFR', '12', '3', '9', '3', '5.6')
                ;
INSERT INTO doctrine_migrations_versions (version) VALUES ('20170513131228');
