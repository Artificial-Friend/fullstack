package com.ua.web.backend.mapper;

import com.ua.web.backend.model.dto.SignUpDto;
import com.ua.web.backend.model.dto.UserDto;
import com.ua.web.backend.model.entity.RoleEnum;
import com.ua.web.backend.model.entity.User;
import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import org.mapstruct.Named;

@Mapper(componentModel = "spring")
public interface UserMapper {

    @Mapping(source = "role", target = "role", qualifiedByName = "roleEnumToString")
    UserDto toUserDto(User user);

    @Mapping(target = "password", ignore = true)
    @Mapping(source = "role", target = "role", qualifiedByName = "roleStringToEnum")
    User signUpDtoToUser(SignUpDto signUpDto);

    @Named("roleStringToEnum")
    default RoleEnum roleStringToEnum(String roleName) {
        return RoleEnum.getRoleEnum(roleName);
    }

    @Named("roleEnumToString")
    default String roleEnumToString(RoleEnum roleName) {
        return roleName.getRoleName(roleName);
    }
}
